<?php

namespace App\UI\Viewer;

interface ViewerInterface
{
  public function render(string $template, array $options): string;
}