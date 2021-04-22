<?php

namespace App\UI\ViewModel;

use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationViewModel
{
  private UserInterface $user;

  public function __construct(UserInterface $user)
  {
    $this->user = $user;
  }

  public function getUser(): UserInterface
  {
    return $this->user;
  }
}