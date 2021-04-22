<?php

namespace App\UI\DTO;

class RegistrationDTO
{

  private ?string $email = null;
  private ?string $pseudo = null;
  private ?string $plainPassword = null;



  /**
   * Get the value of email
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @return  self
   */
  public function setEmail($email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of pseudo
   */
  public function getPseudo()
  {
    return $this->pseudo;
  }

  /**
   * Set the value of pseudo
   *
   * @return  self
   */
  public function setPseudo($pseudo)
  {
    $this->pseudo = $pseudo;

    return $this;
  }

  /**
   * Get the value of plainPassword
   */
  public function getPlainPassword()
  {
    return $this->plainPassword;
  }

  /**
   * Set the value of plainPassword
   *
   * @return  self
   */
  public function setPlainPassword($plainPassword)
  {
    $this->plainPassword = $plainPassword;

    return $this;
  }
}