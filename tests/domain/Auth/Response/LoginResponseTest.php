<?php

namespace App\Tests\domain\Auth\Response;

use DateTime;
use Domain\Auth\User\User;
use PHPUnit\Framework\TestCase;
use Domain\Auth\Response\LoginResponse;
use Ramsey\Uuid\Uuid;

class LoginResponseTest extends TestCase
{

  public function testLoginResponse()
  {
    $loginResponse = new LoginResponse(
      new User(
        Uuid::uuid4(),
        "ok@email.fr",
        "pseudo",
        "password",
        "token",
        new DateTime()
      ),
      true
    );

    $this->assertEquals("ok@email.fr", $loginResponse->getUser()->getEmail());
    $this->assertEquals(true, $loginResponse->isPasswordValid());
  }
}