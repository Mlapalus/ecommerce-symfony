<?php

namespace Domain\Auth\Response;

use Domain\Auth\User\User;

class RecoverPasswordResponse
{
  private User $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getUser(): User
  {
    return $this->user;
  }
}