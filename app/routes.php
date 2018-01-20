<?php

// $app->get('/', function($request, $response){
//
//   return $this->view->render($response, 'home.twig');
// });
//
// $app->get('/eduar', function($request, $response){
//   return $this->view->render($response, 'home.twig');
// });
//
// $app->get('/ingredients', function($request, $response){
//   return 'Home Ingredients';
// });

$app->get('/', 'HomeController:index');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup')->add(new \App\Middleware\CsrfMiddleware($container))->add(new \App\Middleware\OldInputMiddleware($container));

$app->post('/auth/signup', 'AuthController:postSignUp')->add(new \App\Middleware\OldInputMiddleware($container));
