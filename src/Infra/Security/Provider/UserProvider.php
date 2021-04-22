<?php

namespace App\Infra\Security\Provider;

use App\Infra\Security\User;
use Domain\Auth\Gateway\UserGatewayInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
  public UserGatewayInterface $userGateway;

  public function __construct(UserGatewayInterface $userGateway)
  {
    $this->userGateway = $userGateway;
  }

  public function loadUserByUsername(string $username): UserInterface
  {
    return $this->getUserByUserName($username);
  }

  public function refreshUser(UserInterface $user)
  {
    return $this->getUserByUserName($user->getUsername());
  }

  public function getUserByUserName(string $username): UserInterface
  {
    $user = $this->userGateway->getUserByEmail($username);
    if (null === $user) {
      throw new UsernameNotFoundException();
    }
    return new User($user);
  }

  public function supportsClass(string $class)
  {
    return $class === User::class;
  }
}