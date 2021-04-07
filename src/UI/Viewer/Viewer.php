<?php

namespace App\UI\Viewer;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Viewer implements ViewerInterface
{
  private Environment $twig;

  public function __construct(Environment $twig)
  {
    $this->twig = $twig;
  }

  public function render(string $template, array $options): string
  {
    $view = "pages/" . $template . ".html" . ".twig";
    return $this->twig->render($view, $options);
  }
}