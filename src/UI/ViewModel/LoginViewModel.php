<?php

namespace App\UI\ViewModel;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginViewModel
{

  private string $lastUserName;
  private ?string $errorMessage;

  public function __construct(string $lastUserName, ?AuthenticationException $exception)
  {
    $this->lastUserName = $lastUserName;
    $this->errorMessage = $exception !== null ? $exception->getMessage() : null;
  }

  public static function fromAuthenticationUtils(AuthenticationUtils $authenticationUtils)
  {
    return new self(
      $authenticationUtils->getLastUsername(),
      $authenticationUtils->getLastAuthenticationError()
    );
  }

  /**
   * Get the value of lastUserName
   */
  public function getLastUserName()
  {
    return $this->lastUserName;
  }

  /**
   * Get the value of errorMessage
   */
  public function getErrorMessage(): ?string
  {
    return $this->errorMessage;
  }
}