<?php

namespace Domain\Auth\Presenter;

use Domain\Auth\Response\LoginResponse;

interface LoginPresenterInterface
{
  public function present(LoginResponse $response);
}