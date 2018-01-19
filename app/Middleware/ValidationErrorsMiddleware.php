<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {

    $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

    //$this->container->view->getEnvironment()->addGlobal('creador', 'Eduar ASAD');

    unset($_SESSION['errors']);

    $response = $next($request, $response);

    return $response;
  }
}
