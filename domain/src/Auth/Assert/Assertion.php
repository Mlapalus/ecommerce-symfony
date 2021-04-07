<?php

namespace Domain\Auth\Assert;

use function Assert\that;
use Assert\Assertion as BaseAssertion;

use Domain\Auth\Gateway\UserGatewayInterface;
use Domain\Auth\Exception\NonUniqueEmailException;
use Domain\Auth\Exception\NonUniquePseudoException;

class Assertion extends BaseAssertion
{
  public const EXISTING_EMAIL = 500;
  public const EXISTING_PSEUDO = 501;

  public static function nonUniquePseudo(string $pseudo, UserGatewayInterface $gateway): void
  {
    if (!$gateway->isPseudoUnique($pseudo)) {
      throw new NonUniquePseudoException("This pseudo shold be unique !", self::EXISTING_PSEUDO);
    }
  }

  public static function nonUniqueEmail(string $email, UserGatewayInterface $gateway): void
  {
    if (!$gateway->isEmailUnique($email)) {
      throw new NonUniqueEmailException("This email shold be unique !", self::EXISTING_EMAIL);
    }
  }
}