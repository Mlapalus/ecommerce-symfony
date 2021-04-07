<?php

namespace Domain\Auth\Response;

use Domain\Auth\User\User;

class LoginResponse
{

  private ?User $user;
  private bool $passwordValid;

  public function __construct(?User $user, bool $passwordValid)
  {
    $this->user = $user;
    $this->passwordValid = $passwordValid;
  }

  public function getUser(): ?user
  {
    return $this->user;
  }

  public function isPasswordValid(): bool
  {
    return $this->passwordValid;
  }
}