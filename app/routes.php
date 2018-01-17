<?php

$app->get('/', function($request, $response){
  return $this->view->render($response, 'home.twig');
});

$app->get('/eduar', function($request, $response){
  return $this->view->render($response, 'home.twig');
});

$app->get('/ingredients', function($request, $response){
  return 'Home Ingredients';
});
