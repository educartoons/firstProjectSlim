<?php

use App\Middleware\AuthMiddleware;



$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup')->add(new \App\Middleware\CsrfMiddleware($container))->add(new \App\Middleware\OldInputMiddleware($container));

$app->post('/auth/signup', 'AuthController:postSignUp')->add(new \App\Middleware\OldInputMiddleware($container));

$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin')->add(new \App\Middleware\CsrfMiddleware($container))->add(new \App\Middleware\OldInputMiddleware($container));

$app->post('/auth/signin', 'AuthController:postSignIn')->add(new \App\Middleware\OldInputMiddleware($container));



$app->group('', function(){

  $this->get('/', 'HomeController:index')->setName('home');
  $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

})->add(new AuthMiddleware($container));
