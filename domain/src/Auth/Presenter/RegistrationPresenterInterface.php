<?php

namespace Domain\Auth\Presenter;

use Domain\Auth\Response\RegistrationResponse;

interface RegistrationPresenterInterface
{
  public function present(RegistrationResponse $response): void;
}