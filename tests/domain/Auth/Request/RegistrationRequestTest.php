<?php

namespace App\Tests\domain\Auth\Request;

use App\Tests\domain\Auth\UserRepository;
use PHPUnit\Framework\TestCase;
use Domain\Auth\Request\RegistrationRequest;
use Domain\Auth\UseCase\Registration;
use Exception;
use InvalidArgumentException;

class RegistrationRequestTest extends TestCase
{
  private RegistrationRequest $request;
  private UserRepository $gateway;

  public function setUp(): void
  {
    $this->request =
      new RegistrationRequest(
        'email-1@mail.fr',
        'pseudo-1',
        'password-1'
      );

    $this->gateway = new UserRepository();
  }

  public function providerRequest()
  {
    return [
      [new RegistrationRequest('new@email.fr', 'newPseudo', '123456789'), null],
      [new RegistrationRequest('nonunique@email.fr', 'newPseudo', '123456789'), 'InvalidArgumentException'],
      [new RegistrationRequest('new@email.fr', 'nonuniquePseudo', '123456789'), 'InvalidArgumentException'],
      [new RegistrationRequest('', 'newPseudo', '123456789'), 'InvalidArgumentException'],
      [new RegistrationRequest('new@email.fr', '', '123456789'), 'InvalidArgumentException'],
      [new RegistrationRequest('new@email.fr', 'newPseudo', '1234567'), 'InvalidArgumentException'],
    ];
  }

  public function testRegistrationRequest()
  {
    $this->assertEquals('email-1@mail.fr', $this->request->getEmail());
    $this->assertEquals('pseudo-1', $this->request->getPseudo());
    $this->assertEquals('password-1', $this->request->getPlainpassword());
  }

  public function testCreateRegitrationRequest()
  {
    $newRequest = $this->request->create(
      'new@email.fr',
      'newPseudo',
      'newPassword',
    );

    $this->assertInstanceOf(RegistrationRequest::class, $newRequest);
  }

  /**
   * Undocumented function
   * @dataProvider providerRequest
   * @param RegistrationRequest $request
   * @param string $exception
   * @return void
   */
  public function testValidate(RegistrationRequest $request, ?string $exception)
  {
    if ($exception) {
      $this->expectException(InvalidArgumentException::class);
    } else {
      $this->assertIsNotString($exception);
    }

    $request->validate($this->gateway);
  }
}