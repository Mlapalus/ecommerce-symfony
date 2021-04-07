<?php

namespace Domain\Auth\UseCase;

use Domain\Auth\User\User;
use Domain\Auth\Request\RegistrationRequest;
use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\Response\RegistrationResponse;
use Domain\Auth\Presenter\RegistrationPresenterInterface;

class Registration
{
  private UserGatewayInterface $gateway;

  public function __construct(UserGatewayInterface $gateway)
  {
    $this->gateway = $gateway;
  }

  public function execute(
    RegistrationRequest $request,
    RegistrationPresenterInterface $presenter
  ) {
    $request->validate($this->gateway);
    $user = User::fromRegistration($request);
    $this->gateway->register($user);
    $presenter->present(new RegistrationResponse($user->getEmail()));
  }
}