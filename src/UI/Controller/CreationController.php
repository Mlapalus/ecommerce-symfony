<?php

namespace App\UI\Controller;

use Symfony\Component\HttpFoundation\Response;

class CreationController
{
  public function index(): Response
  {
    return new Response('Page Creations', Response::HTTP_OK);
  }
}