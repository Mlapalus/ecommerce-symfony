<?php

namespace Domain\Auth\Gateway;

use Domain\Auth\User\User;

interface UserGatewayInterface
{
  public function getUserByEmail(string $email): ?User;
  public function isEmailUnique(?string $email): bool;
  public function isPseudoUnique(?string $pseudo): bool;
  public function register(User $user): void;
  public function update(User $user): void;
}