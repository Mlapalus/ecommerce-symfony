<?php

namespace Domain\Auth\Response;

class RegistrationResponse
{

  private string $email;

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
}