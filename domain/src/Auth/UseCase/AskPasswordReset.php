<?php

namespace Domain\Auth\UseCase;

use Ramsey\Uuid\Uuid;

use Domain\Auth\User\User;
use Domain\Auth\Gateway\UserGatewayInterface;
use Symfony\Component\Routing\RouterInterface;
use Domain\Auth\Provider\MailProviderInterface;
use Domain\Auth\Request\AskPasswordResetRequest;
use Domain\Auth\Response\AskPasswordResetResponse;
use Domain\Auth\Presenter\AskPasswordResetPresenterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AskPasswordReset
{
  private UserGatewayInterface $gateway;
  private MailProviderInterface $mailer;
  private RouterInterface $urlGenerator;

  public function __construct(
    UserGatewayInterface $gateway,
    MailProviderInterface $mailer,
    RouterInterface $urlGenerator
  ) {
    $this->gateway = $gateway;
    $this->mailer = $mailer;
    $this->urlGenerator = $urlGenerator;
  }

  public function execute(
    AskPasswordResetRequest $request,
    AskPasswordResetPresenterInterface $presenter
  ) {
    $request->validate();

    $user = $this->gateway->getUserByEmail($request->getEmail());

    if ($user) {
      User::requestPasswordReset($user, Uuid::uuid4());

      $this->gateway->update($user);

      $link = $this->urlGenerator->generate(
        'recover_password',
        [
          'email' => $user->getEmail(),
          'token' => $user->getResetPasswordToken(),
        ],
        UrlGeneratorInterface::ABSOLUTE_URL
      );

      $this->mailer->sendPasswordResetLink(
        $user->getEmail(),
        $user->getPseudo(),
        $link
      );
    }
    $presenter->present(new AskPasswordResetResponse($user));
  }
}