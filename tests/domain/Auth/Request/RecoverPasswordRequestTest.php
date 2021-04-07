<?php

namespace App\Tests\domain\Auth\Request;

use PHPUnit\Framework\TestCase;
use Domain\Auth\Request\RecoverPasswordRequest;
use InvalidArgumentException;


class RecoverPasswordRequestTest extends TestCase
{
  private RecoverPasswordRequest $request;

  public function setUp(): void
  {
    $this->request =
      new RecoverPasswordRequest(
        'email-1@mail.fr',
        'password-1',
        'token'
      );
  }

  public function providerRequest()
  {
    return [
      [new RecoverPasswordRequest('mon@email.fr', '123456789', 'token'), null],
      [new RecoverPasswordRequest('', '123456789', 'token'), 'InvalidArgumentException'],
      [new RecoverPasswordRequest('mon@email.fr', '', 'token'), 'InvalidArgumentException'],
      [new RecoverPasswordRequest('mon@email.fr', '123456789', ''), 'InvalidArgumentException'],
      [new RecoverPasswordRequest('mon@email.fr', '123456', 'token'), 'InvalidArgumentException']
    ];
  }

  public function testRecoverPasswordRequest()
  {
    $this->assertEquals('email-1@mail.fr', $this->request->getEmail());
    $this->assertEquals('password-1', $this->request->getNewPlainpassword());
    $this->assertEquals('token', $this->request->getToken());
  }

  /**
   * Undocumented function
   * @dataProvider providerRequest
   * @param RecoverPasswordRequest $request
   * @param string $exception
   * @return void
   */
  public function testValidate(RecoverPasswordRequest $request, ?string $exception)
  {
    if ($exception) {
      $this->expectException(InvalidArgumentException::class);
    } else {
      $this->assertIsNotString($exception);
    }

    $request->validate();
  }
}