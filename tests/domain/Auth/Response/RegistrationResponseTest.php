<?php

namespace App\Tests\domain\Auth\Response;

use PHPUnit\Framework\TestCase;
use Domain\Auth\Response\RegistrationResponse;

class RegistrationResponseTest extends TestCase
{

  public function testAskPasswordResetResponse()
  {
    $response = new RegistrationResponse("ok@email.fr");

    $this->assertEquals("ok@email.fr", $response->getEmail());
  }
}