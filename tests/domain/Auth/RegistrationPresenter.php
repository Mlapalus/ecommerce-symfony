<?php

namespace App\Tests\domain\Auth;

use Domain\Auth\Presenter\RegistrationPresenterInterface;
use Domain\Auth\Response\RegistrationResponse;

class RegistrationPresenter implements RegistrationPresenterInterface
{
  public function present(RegistrationResponse $response): void
  {
  }
}