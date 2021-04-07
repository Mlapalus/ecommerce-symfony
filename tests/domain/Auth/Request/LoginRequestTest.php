<?php

namespace App\Tests\domain\Auth\Request;

use PHPUnit\Framework\TestCase;
use Domain\Auth\Request\LoginRequest;
use InvalidArgumentException;


class LoginRequestTest extends TestCase
{
  private LoginRequest $request;

  public function setUp(): void
  {
    $this->request =
      new LoginRequest(
        'email-1@mail.fr',
        'password-1'
      );
  }

  public function providerRequest()
  {
    return [
      [new LoginRequest('mon@email.fr', '123456789'), null],
      [new LoginRequest('', '123456789'), 'InvalidArgumentException'],
      [new LoginRequest('mon@email.fr', ''), 'InvalidArgumentException']
    ];
  }

  public function testLoginRequest()
  {
    $this->assertEquals('email-1@mail.fr', $this->request->getEmail());
    $this->assertEquals('password-1', $this->request->getpassword());
  }

  public function testCreateLoginRequest()
  {
    $newRequest = $this->request->create(
      'new@email.fr',
      'newPassword',
    );

    $this->assertInstanceOf(LoginRequest::class, $newRequest);
  }

  /**
   * Undocumented function
   * @dataProvider providerRequest
   * @param LoginRequest $request
   * @param string $exception
   * @return void
   */
  public function testValidate(LoginRequest $request, ?string $exception)
  {
    if ($exception) {
      $this->expectException(InvalidArgumentException::class);
    } else {
      $this->assertIsNotString($exception);
    }

    $request->validate();
  }
}