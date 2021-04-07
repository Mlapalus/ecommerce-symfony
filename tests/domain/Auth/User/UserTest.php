<?php
var_dump(php_ini_loaded_file(), php_ini_scanned_files());

namespace App\Tests\domain\Auth\User;

use Ramsey\Uuid\Uuid;
use Domain\Auth\User\User;
use PHPUnit\Framework\TestCase;
use Domain\Auth\Request\RegistrationRequest;
use Domain\Auth\Request\RecoverPasswordRequest;

class UserTest extends TestCase
{
  private $id;
  private User $user;
  private RegistrationRequest $request;

  public function setUp(): void
  {
    $this->id = Uuid::uuid4();
    $this->user = new User(
      $this->id,
      'nok@email.fr',
      'nopseudo',
      'noPassword'
    );

    $this->request = new RegistrationRequest(
      'ok@email.fr',
      'pseudo',
      'plainPassword'
    );
  }

  public function testGetter()
  {
    $this->assertEquals($this->id, $this->user->getId());
    $this->assertEquals('nok@email.fr', $this->user->getEmail());
    $this->assertEquals('nopseudo', $this->user->getPseudo());
    $this->assertEquals('noPassword', $this->user->getPassword());
  }

  public function testFromRegistration()
  {
    $newUser = $this->user->fromRegistration($this->request);

    $this->assertInstanceOf(User::class, $newUser);
    $this->assertTrue(password_verify('plainPassword', $newUser->getPassword()));
  }

  public function testResetPassword()
  {
    $request = new RecoverPasswordRequest(
      'new@email.fr',
      'newpassword',
      'token'
    );

    $this->user->resetPassword($this->user, $request);

    $this->assertTrue(password_verify('newpassword', $this->user->getPassword()));
  }

  public function testRequestResetPassword()
  {
    $this->user->requestPasswordReset($this->user, 'token');

    $this->assertNotNull($this->user->getPasswordResetRequestAt());
    $this->assertInstanceOf(\DateTimeImmutable::class, $this->user->getPasswordResetRequestAt());
    $this->assertEquals('token', $this->user->getResetPasswordToken());
  }
}