<?php

namespace App\UI\Controller;

use App\UI\Viewer\Viewer;
use App\UI\Viewer\ViewerInterface;
use Symfony\Component\HttpFoundation\Response;

class AboutController
{
  private ViewerInterface $viewer;

  public function __construct(Viewer $viewer)
  {
    $this->viewer = $viewer;
  }
  public function index(): Response
  {
    return new Response($this->viewer->render(
      "about",
      []
    ));
  }
}