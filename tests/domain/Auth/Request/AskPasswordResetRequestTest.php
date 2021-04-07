<?php

namespace App\Tests\domain\Auth\Request;

use PHPUnit\Framework\TestCase;
use Domain\Auth\Request\AskPasswordResetRequest;
use InvalidArgumentException;


class AskPasswordResetRequestTest extends TestCase
{
  private AskPasswordResetRequest $request;

  public function setUp(): void
  {
    $this->request =
      new AskPasswordResetRequest(
        'email-1@mail.fr'
      );
  }

  public function providerRequest()
  {
    return [
      [new AskPasswordResetRequest('mon@email.fr'), null],
      [new AskPasswordResetRequest(''), 'InvalidArgumentException'],
      [new AskPasswordResetRequest('aa'), 'InvalidArgumentException'],
    ];
  }

  public function testAskPasswordResetRequest()
  {
    $this->assertEquals('email-1@mail.fr', $this->request->getEmail());
  }

  public function testCreateAskPasswordResetRequest()
  {
    $newRequest = $this->request->create(
      'new@email.fr'
    );

    $this->assertInstanceOf(AskPasswordResetRequest::class, $newRequest);
  }

  /**
   * Undocumented function
   * @dataProvider providerRequest
   * @param AskPasswordResetRequest $request
   * @param string $exception
   * @return void
   */
  public function testValidate(AskPasswordResetRequest $request, ?string $exception)
  {
    if ($exception) {
      $this->expectException(InvalidArgumentException::class);
    } else {
      $this->assertIsNotString($exception);
    }

    $request->validate();
  }
}