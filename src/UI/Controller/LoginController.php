<?php

namespace App\UI\Controller;

use App\UI\Viewer\Viewer;
use App\UI\Viewer\ViewerInterface;
use App\UI\ViewModel\LoginViewModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController
{
  private ViewerInterface $viewer;

  public function __construct(Viewer $viewer)
  {
    $this->viewer = $viewer;
  }

  public function index(AuthenticationUtils $authenticationUtils): Response
  {
    return new Response($this->viewer->render(
      "login",
      [
        "vm" => LoginViewModel::fromAuthenticationUtils($authenticationUtils)
      ]
    ));
  }
}