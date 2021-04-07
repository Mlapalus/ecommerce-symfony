<?php

namespace App\Tests\domain\Auth\Response;

use Ramsey\Uuid\Uuid;
use Domain\Auth\User\User;
use PHPUnit\Framework\TestCase;
use Domain\Auth\Response\AskPasswordResetResponse;

class AskPasswordResetResponseTest extends TestCase
{

  public function testAskPasswordResetResponse()
  {
    $response = new AskPasswordResetResponse(
      new User(
        Uuid::uuid4(),
        "ok@email.fr",
        "pseudo",
        "password",
        "token",
        new \DateTime()
      )
    );

    $this->assertEquals("ok@email.fr", $response->getUser()->getEmail());
  }
}