<?php

namespace App\Middleware;

class AuthMiddleware extends Middleware
{
  public function __invoke($request, $response, $next)
  {

    // Check if the user is signed in

    if( !$this->container->auth->check() ){
      return $response->withRedirect($this->container->router->pathFor('auth.signin'));
    }

    $response = $next($request, $response);

    return $response;
  }
}
