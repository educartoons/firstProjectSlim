<?php

namespace App\Controller;

use Slim\Views\Twig as View;

class Controller
{
  public function __construct($container)
  {
    $this->container = $container;
  }
}
