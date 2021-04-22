<?php

namespace Domain\Auth\Request;

use Domain\Auth\Assert\Assertion;
use Assert\AssertionFailedException;

class RecoverPasswordRequest
{
  private string $email;
  private string $newPlainPassword;
  private string $token;

  public function __construct(
    string $email,
    string $newPlainPassword,
    string $token
  ) {
    $this->email = $email;
    $this->newPlainPassword = $newPlainPassword;
    $this->token = $token;
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Get the value of newPlainPassword
   */
  public function getNewPlainPassword()
  {
    return $this->newPlainPassword;
  }

  /**
   * Get the value of token
   */
  public function getToken()
  {
    return $this->token;
  }

  /**
   * validate
   *
   * @throws AssertionFailedException
   */
  public function validate(): void
  {
    Assertion::notBlank($this->email);
    Assertion::notBlank($this->token);
    Assertion::notBlank($this->newPlainPassword);
    Assertion::minLength($this->newPlainPassword, 8);
  }
}