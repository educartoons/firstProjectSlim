<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Views\Twig as View;

class HomeController extends Controller
{

  public function index($request, $response)
  {

    $user = $this->db->table('users')->find(1);


    // GET
    // $user = User::where('id', '2')->first();

    // CREATE
    // User::create([
    //   'name' => 'Mike Herrera',
    //   'email' => 'kevin.mike94@gmail.com',
    //   'password' => '123456'
    // ]);
    //
    // var_dump($user->name);
    // die();

    return $this->view->render($response, 'home.twig');
  }

}
