<?php

namespace App\Tests\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends ControllerTestCase
{
  public function testSuccessful()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, "/login");
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    $this->assertPageTitleSame("Page de LOGIN");
    $this->assertCheckboxNotChecked("_remember_me");
    $this->assertSelectorExists("form");
  }
}