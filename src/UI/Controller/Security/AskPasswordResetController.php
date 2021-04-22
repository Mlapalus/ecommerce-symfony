<?php

namespace App\UI\Controller\Security;

use Symfony\Component\HttpFoundation\Response;

class AskPasswordResetController
{

  public function index(): Response
  {
    return new Response('AskPasswordReset', 200);
  }
}