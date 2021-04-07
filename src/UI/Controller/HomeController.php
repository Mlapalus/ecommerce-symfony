<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController
{
  public function index(): Response
  {
    return new Response('Page Home', Response::HTTP_OK);
  }
}