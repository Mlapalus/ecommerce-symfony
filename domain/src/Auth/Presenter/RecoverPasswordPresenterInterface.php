<?php

namespace Domain\Auth\Presenter;

use Domain\Auth\Response\RecoverPasswordResponse;

interface RecoverPasswordPresenterInterface
{
  public function present(RecoverPasswordResponse $response): void;
}