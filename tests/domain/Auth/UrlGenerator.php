<?php

namespace App\Tests\domain\Auth;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class UrlGenerator implements RouterInterface
{
  public function getRouteCollection()
  {
  }
  public function match(string $pathinfo)
  {
  }

  public function setContext(RequestContext $context)
  {
  }

  public function getContext()
  {
  }

  public function generate(
    string $name,
    array $parameters = [],
    int $referenceType = self::ABSOLUTE_PATH
  ): string {

    return "linkToResetThePassword";
  }
}