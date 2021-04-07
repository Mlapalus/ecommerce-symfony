<?php

namespace App\Tests\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactControllerTest extends ControllerTestCase
{
  public function testSuccessful()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, "/contact");
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }
}