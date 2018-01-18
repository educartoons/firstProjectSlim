<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller
{

  public function index($request, $response)
  {
    //return 'It is the home';
    return $this->container->view->render($response, 'home.twig');
  }

}
