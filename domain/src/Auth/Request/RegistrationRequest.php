<?php

namespace Domain\Auth\Request;

use Domain\Auth\Assert\Assertion;
use Domain\Auth\Gateway\UserGatewayInterface;

class RegistrationRequest
{
  private string $email;
  private string $pseudo;
  private string $plainpassword;

  public function __construct(
    string $email,
    string $pseudo,
    string $plainpassword
  ) {
    $this->email = $email;
    $this->pseudo = $pseudo;
    $this->plainpassword = $plainpassword;
  }

  public static function create(
    string $email,
    string $pseudo,
    string $plainpassword
  ): self {
    return new self($email, $pseudo, $plainpassword);
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Get the value of pseudo
   */
  public function getPseudo()
  {
    return $this->pseudo;
  }

  /**
   * Get the value of plainpassword
   */
  public function getPlainpassword()
  {
    return $this->plainpassword;
  }

  /**
   * validate
   *
   * @param  UserGatewayInterface $gateway
   * @throws AssertionFailedException
   */
  public function validate(UserGatewayInterface $gateway): void
  {
    Assertion::notBlank($this->email);
    Assertion::email($this->email);
    Assertion::nonUniqueEmail($this->email, $gateway);
    Assertion::notBlank($this->pseudo);
    Assertion::nonUniquePseudo($this->pseudo, $gateway);
    Assertion::notBlank($this->plainpassword);
    Assertion::minLength($this->plainpassword, 8);
  }
}