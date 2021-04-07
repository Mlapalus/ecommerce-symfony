<?php

namespace Domain\Auth\Request;

use Domain\Auth\Assert\Assertion;


class AskPasswordResetRequest
{
  private $email;

  public function __construct(string $email)
  {
    $this->email = $email;
  }
  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  public static function create(string $email): self
  {
    return new self($email);
  }

  public function validate(): void
  {
    Assertion::notBlank($this->email, "Email should not be blank.");
    Assertion::email($this->email);
  }
}