<?php

namespace Domain\Auth\UseCase;

use Domain\Auth\User\User;
use Domain\Auth\Request\LoginRequest;
use Domain\Auth\Response\LoginResponse;
use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\Presenter\LoginPresenterInterface;

class Login
{
  private UserGatewayInterface $userGateway;

  public function __construct(UserGatewayInterface $userGateway)
  {
    $this->userGateway = $userGateway;
  }

  public function execute(
    LoginRequest $request,
    LoginPresenterInterface $presenter
  ) {
    $request->validate();

    $user = $this->userGateway->getUserByEmail($request->getEmail());
    var_dump($user);

    if ($user) {
      $passwordValid = password_verify($request->getPassword(), $user->getPassword());
    }

    $presenter->present(new LoginResponse($user, $passwordValid ?? false));
  }
}