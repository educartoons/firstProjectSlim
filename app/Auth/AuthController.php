<?php

namespace App\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{

  public function getSignOut($request, $response)
  {
    $this->logout();
    $this->flash->addMessage('success', 'Usted ha cerrado sesión satisfactoriamente.');
    return $response->withRedirect($this->router->pathFor('auth.signin'));
  }



  public function getSignUp($request, $response){

    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response){

    $validation = $this->validator->validate($request, [
      'email' => v::noWhiteSpace()->notEmpty()->EmailAvailable(),
      'name' => v::notEmpty()->alpha(),
      'password' => v::noWhiteSpace()->notEmpty()
    ]);

    if($validation->failed()){
      $this->flash->addMessage('warning', 'Complete bien los campos');
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }else{
      $user= User::create([
        'name' => $request->getParam('name'),
        'email' => $request->getParam('email'),
        'password' => password_hash( $request->getParam('password'), PASSWORD_DEFAULT )
      ]);

      if($user){
        $this->auth->attempt($user->email, $request->getParam('password'));
        $this->flash->addMessage('success', 'Su usuario ha sido creado satisfactoriamente.');
        return $response->withRedirect($this->router->pathFor('home'));
      }else{
        $this->flash->addMessage('danger', 'No se pudo registrar, póngase en contacto con el administrador.');
        return $response->withRedirect($this->router->pathFor('auth.signup'));
      }
    }

  }

  public function getSignIn($request, $response){

    return $this->view->render($response, 'auth/signin.twig');
  }

  public function postSignIn($request, $response){
    $validation = $this->validator->validate($request, [
      'email' => v::noWhiteSpace()->notEmpty(),
      'password' => v::noWhiteSpace()->notEmpty()
    ]);

    if($validation->failed()){
      $this->flash->addMessage('warning', 'Complete bien los campos');
      return $response->withRedirect($this->router->pathFor('auth.signin'));
    }else{
      $auth = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));
      // Check if the password is correct
      if($auth){
        $this->flash->addMessage('success', 'Usted se ha autentificado satisfactoriamente.');
        return $response->withRedirect($this->router->pathFor('home'));
      }else{
        $this->flash->addMessage('warning', 'Sus credenciales no coinciden.');
        return $response->withRedirect($this->router->pathFor('auth.signin'));
      }
    }
  }

  public function logout()
  {
    unset($_SESSION['user']);
  }

}
