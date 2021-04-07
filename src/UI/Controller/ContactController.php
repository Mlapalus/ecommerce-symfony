<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;

class ContactController
{
  public function index(): Response
  {
    return new Response('Page Contact', Response::HTTP_OK);
  }
}