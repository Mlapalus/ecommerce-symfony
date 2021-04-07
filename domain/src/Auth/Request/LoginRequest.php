<?php

namespace Domain\Auth\Request;

use Domain\Auth\Assert\Assertion;

class LoginRequest
{
  private string $email;
  private string $password;

  public function __construct(
    string $email,
    string $password
  ) {
    $this->email = $email;
    $this->password = $password;
  }

  public function create(
    string $email,
    string $password
  ): self {
    return new self($email, $password);
  }

  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }


  /**
   * Get the value of password
   */
  public function getPassword()
  {
    return $this->password;
  }

  public function validate(): void
  {
    Assertion::notBlank($this->email, "Email should not be blank.");
    Assertion::notBlank($this->password, "Password should not be blank.");
  }
}