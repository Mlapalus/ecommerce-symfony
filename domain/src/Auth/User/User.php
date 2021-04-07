<?php

namespace Domain\Auth\User;

use DateTime;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Domain\Auth\Request\RegistrationRequest;
use Domain\Auth\Request\RecoverPasswordRequest;

class User
{
  private UuidInterface $id;

  private string $email;

  private string $pseudo;

  private string $password;

  private ?string $resetPasswordToken = null;

  private ?DateTimeInterface $passwordResetRequestAt = null;

  public function __construct(
    UuidInterface $id,
    string $email,
    string $pseudo,
    string $password,
    ?string $resetPasswordToken = null,
    ?DateTimeInterface $passwordResetRequestedAt = null
  ) {

    $this->id = $id;
    $this->email = $email;
    $this->pseudo = $pseudo;
    $this->password = $password;
    $this->resetPasswordToken = $resetPasswordToken;
    $this->passwordResetRequestAt = $passwordResetRequestedAt;
  }

  public static function fromRegistration(RegistrationRequest $request): self
  {
    return new self(
      Uuid::uuid4(),
      $request->getEmail(),
      $request->getPseudo(),
      password_hash($request->getPlainPassword(), PASSWORD_ARGON2I)
    );
  }

  public static function resetPassword(self $user, RecoverPasswordRequest $request): void
  {
    $password = password_hash($request->getNewPlainPassword(), PASSWORD_ARGON2I);

    if ($password) {
      $user->password = $password;
    }

    $user->resetPasswordToken = null;
    $user->passwordResetRequestAt = null;
  }

  public static function requestPasswordReset(self $user, string $token): void
  {
    $user->passwordResetRequestAt = new DateTimeImmutable();
    $user->resetPasswordToken = $token;
  }


  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get the value of email
   */
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * Get the value of pseudo
   */
  public function getPseudo(): string
  {
    return $this->pseudo;
  }

  /**
   * Get the value of password
   */
  public function getPassword(): string
  {
    return $this->password;
  }

  /**
   * Get the value of resetPasswordToken
   */
  public function getResetPasswordToken(): string
  {
    return $this->resetPasswordToken;
  }

  /**
   * Get the value of passwordResetRequestAt
   */
  public function getPasswordResetRequestAt(): DateTimeImmutable
  {
    return $this->passwordResetRequestAt;
  }
}