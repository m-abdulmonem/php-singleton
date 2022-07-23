<?php

namespace App\Controllers;
use System\Controller;

class ErrorController extends Controller
{

    public function index(){
        return $this->view->render('main-layout/error/404');
    }

}