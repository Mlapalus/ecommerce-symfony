<?php

namespace App\Infra\Security;

use Domain\Auth\User\User as DomainUser;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
  private DomainUser $user;

  public function __construct(DomainUser $user)
  {
    $this->user = $user;
  }

  public function getRoles()
  {
    return ['ROLE_USER'];
  }

  public function getPassword()
  {
    return $this->user->getPassword();
  }

  public function getSalt()
  {
  }

  public function getUsername()
  {
    return $this->user->getEmail();
  }

  public function eraseCredentials()
  {
  }
}