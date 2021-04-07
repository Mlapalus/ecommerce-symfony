<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;

class AboutController
{
  public function index(): Response
  {
    return new Response('Page About', Response::HTTP_OK);
  }
}