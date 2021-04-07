<?php

namespace App\Tests\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AboutControllerTest extends ControllerTestCase
{
  public function testSuccessful()
  {
    $client = static::createClient();
    $client->request(Request::METHOD_GET, "/a-propos");
    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }
}