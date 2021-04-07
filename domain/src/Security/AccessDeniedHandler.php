<?php

namespace Domain\Security;

use App\UI\Viewer\Viewer;
use App\UI\Viewer\ViewerInterface;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
  private UrlGeneratorInterface $urlGenerator;
  private ViewerInterface $view;

  public function __construct(UrlGeneratorInterface $urlGenerator, Viewer $view)
  {
    $this->urlGenerator = $urlGenerator;
    $this->view = $view;
  }

  public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
  {
    return new Response($this->view->render('bundles/TwigBundle/Exception/error403.html.twig', []), Response::HTTP_FORBIDDEN);
  }
}