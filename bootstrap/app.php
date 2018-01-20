<?php

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

use \Slim\Views\TwigExtension;

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    'db' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'slim-test',
      'username' => 'root',
      'password' => 'root',
      'charset' => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix' => ''
    ]
  ]
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = $capsule;

$container['validator'] = function($container) {
  return new App\Validation\Validator;
};

$container['view'] = function($container){
  $view = new \Slim\Views\Twig(__DIR__.'/../resources/views', [
    'cache' => false
  ]);

  $view->addExtension(new TwigExtension(
    $container->router,
    $container->request->getUri()
  ));

  return $view;
};

$container['HomeController'] = function($container){
  return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
  return new \App\Auth\AuthController($container);
};

$container['csrf'] = function($container){
  return new \Slim\Csrf\Guard;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
//$app->add(new \App\Middleware\OldInputMiddleware($container));
//$app->add(new \App\Middleware\CsrfMiddleware($container));

$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';


?>
