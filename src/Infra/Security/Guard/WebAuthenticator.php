<?php

namespace App\Infra\Security\Guard;

use App\Infra\Security\User;
use Domain\Auth\UseCase\Login;
use Assert\AssertionFailedException;
use Domain\Auth\Request\LoginRequest;
use Domain\Auth\Response\LoginResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Domain\Auth\Presenter\LoginPresenterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class WebAuthenticator extends AbstractFormLoginAuthenticator implements LoginPresenterInterface
{
  use TargetPathTrait;

  public const LOGIN_ROUTE = 'login';

  private Login $login;
  private LoginResponse $response;

  public function __construct(Login $login)
  {
    $this->login = $login;
  }

  public function getLoginUrl()
  {
    return "/login";
  }

  public function supports(Request $request)
  {
    return self::LOGIN_ROUTE === $request->attributes->get('_route')
      && $request->isMethod('POST');
  }

  public function getUser($credentials, UserProviderInterface $userProvider)
  {
    try {
      $login = new LoginRequest($credentials[0], $credentials[1]);
      $this->login->execute($login, $this);
    } catch (AssertionFailedException $exceiption) {
      throw new AuthenticationException($exceiption->getMessage());
    }

    if (null === $this->response->getUser()) {
      throw new UsernameNotFoundException("Email ou Mot de Passe incorrect !");
    }

    $user = $this->response->getUser();
    return new User($user);
  }

  public function checkCredentials($credentials, UserInterface $user)
  {
    if (!$this->response->isPasswordValid()) {
      throw new AuthenticationException('Wrong credentials !');
    }
    return true;
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
  {
    return new RedirectResponse('/');
  }

  public function present(LoginResponse $response)
  {
    $this->response = $response;
  }

  public function getCredentials(Request $request)
  {
    $credentials =
      [
        $request->get("email", ""),
        $request->get("password", "")
      ];
    $request->getSession()->set(Security::LAST_USERNAME, $credentials[0]);
    return $credentials;
  }
}