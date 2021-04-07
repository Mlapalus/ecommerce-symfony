<?php

namespace App\Tests\domain\Auth;

use Domain\Auth\Presenter\LoginPresenterInterface;
use Domain\Auth\Response\LoginResponse;

class LoginPresenter implements LoginPresenterInterface
{

  private ?LoginResponse $response = null;

  public function present(LoginResponse $response)
  {
    $this->response = $response;
  }

  public function getResponse(): ?LoginResponse
  {
    return $this->response;
  }
}