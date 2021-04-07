<?php

namespace App\Tests\domain\Auth;

use Domain\Auth\Presenter\AskPasswordResetPresenterInterface;
use Domain\Auth\Response\AskPasswordResetResponse;

class AskPasswordResetPresenter implements AskPasswordResetPresenterInterface
{
  public function present(AskPasswordResetResponse $response): void
  {
  }
}