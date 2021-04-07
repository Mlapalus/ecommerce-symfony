<?php

namespace Domain\Auth\Provider;

interface MailProviderInterface
{
  public function sendPasswordResetLink(
    string $email,
    string $pseudo,
    string $link
  ): void;
}