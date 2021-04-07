<?php

namespace App\Tests\domain\Auth;

use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\User\User;
use Ramsey\Uuid\Uuid;

class UserRepository implements UserGatewayInterface
{
  public function getUserByEmail(string $email): ?User
  {
    if ('ok@email.com' === $email) {
      return new User(
        Uuid::uuid4(),
        'ok@email.com',
        'pseudo-1',
        password_hash('password-1', PASSWORD_ARGON2I)
      );
    } else {
      return null;
    }
  }

  public function isEmailUnique(?string $email): bool
  {
    return ('new@email.fr' === $email);
  }

  public function isPseudoUnique(?string $pseudo): bool
  {
    return ('newPseudo' === $pseudo);
  }

  public function register(User $user): void
  {
  }

  public function update(User $user): void
  {
  }
}