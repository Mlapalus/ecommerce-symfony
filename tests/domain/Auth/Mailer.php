<?php

namespace App\Tests\domain\Auth;

use Domain\Auth\Provider\MailProviderInterface;

class Mailer implements MailProviderInterface
{
  public function sendPasswordResetLink(string $email, string $pseudo, string $link): void
  {
  }
}