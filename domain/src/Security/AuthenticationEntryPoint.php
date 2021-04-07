<?php

namespace Domain\Security;

use Domain\Security\AccessDeniedHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
  private UrlGeneratorInterface $urlGenerator;
  private AccessDeniedHandler $accessDeniedHandler;

  public function __construct(
    UrlGeneratorInterface $urlGenerator,
    AccessDeniedHandler $accessDeniedHandler
  ) {
    $this->urlGenerator = $urlGenerator;
    $this->accessDeniedHandler = $accessDeniedHandler;
  }

  public function start(Request $request, AuthenticationException $authException = null): Response
  {
    $previous = $authException ? $authException->getPrevious() : null;

    // Parque le composant security est un peu bête et ne renvoie pas un AccessDenied pour les utilisateur connecté avec un cookie
    // On redirige le traitement de cette situation vers le AccessDeniedHandler
    if (
      $authException instanceof InsufficientAuthenticationException &&
      $previous instanceof AccessDeniedException &&
      $authException->getToken() instanceof RememberMeToken
    ) {
      return $this->accessDeniedHandler->handle($request, $previous);
    }

    return new RedirectResponse($this->urlGenerator->generate('auth_login'));
  }
}