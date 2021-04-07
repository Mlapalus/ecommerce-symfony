<?php

namespace Domain\Auth\UseCase;

use DateTimeImmutable;
use Domain\Auth\User\User;
use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\Request\RecoverPasswordRequest;
use Domain\Auth\Response\RecoverPasswordResponse;
use Domain\Auth\Presenter\RecoverPasswordPresenterInterface;
use Domain\Auth\Exception\PasswordRecoveryInvalidTokenException;

class RecoverPassword
{

  public const TOKEN_TIMEOUT = 600;

  private UserGatewayInterface $gateway;

  public function __construct(UserGatewayInterface $gateway)
  {
    $this->gateway = $gateway;
  }

  public function execute(
    RecoverPasswordRequest $request,
    RecoverPasswordPresenterInterface $presenter
  ) {

    $request->validate();

    $user = $this->gateway->getUserByEmail($request->getEmail());

    if (null === $user) {
      throw new PasswordRecoveryInvalidTokenException(
        "User with {$request->getEmail()} doesn't exist.",
        400
      );
    }

    if (!$this->isTokenValid($request, $user)) {
      throw new PasswordRecoveryInvalidTokenException("Invalid Token", 400);
    }

    User::resetPassword($user, $request);

    $this->gateway->update($user);

    $presenter->present(new RecoverPasswordResponse($user));
  }

  public function isTokenValid(
    RecoverPasswordRequest $request,
    User $user
  ) {
    if (!$user->getPasswordResetRequestAt()) {
      return false;
    }
    $interval =
      (new DateTimeImmutable())->getTimestamp() - $user->getPasswordResetRequestAt()->getTimestamp();

    return $request->getToken() === $user->getResetPasswordToken() && self::TOKEN_TIMEOUT >= $interval;
  }
}