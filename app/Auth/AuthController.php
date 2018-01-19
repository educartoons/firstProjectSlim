<?php

namespace App\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{

  public function getSignUp($request, $response){

    return $this->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response){

    $validation = $this->validator->validate($request, [
      'email' => v::noWhiteSpace()->notEmpty(),
      'name' => v::notEmpty()->alpha(),
      'password' => v::noWhiteSpace()->notEmpty()
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->router->pathFor('auth.signup'));
    }else{
      User::create([
        'name' => $request->getParam('name'),
        'email' => $request->getParam('email'),
        'password' => password_hash( $request->getParam('password'), PASSWORD_DEFAULT )
      ]);

      if(User){
        return $response->withRedirect($this->router->pathFor('auth.signup'));
      }else{
        return 'No se registró';
        die();
      }
    }


  }

}
