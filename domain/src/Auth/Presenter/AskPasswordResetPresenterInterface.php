<?php

namespace Domain\Auth\Presenter;

use Domain\Auth\Response\AskPasswordResetResponse;

interface AskPasswordResetPresenterInterface
{
  public function present(AskPasswordResetResponse $response): void;
}