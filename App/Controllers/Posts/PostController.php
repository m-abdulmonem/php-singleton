<?php

namespace App\Controllers\Posts;
use System\Controller;
/**
 *
 */
class PostController extends Controller
{

  public function index(){

    echo $_GET['text'] . "<br />";
    echo $_GET['id'] . "<br />";
  }

}
