<?php
namespace App\Controllers;
use System\Controller;

class HomeController extends Controller
{

    /**
     *
     */
    public  function  index(){
        echo "Welcome";
    }

    public function joker()
    {
        //['users' => $this->model('users')->all()]
        $data['users'] =  $this->model('users')->all();
        return $this->view->render('Users/joker',$data);

    }

    public function t(){
        return $this->model1();
    }

    public function model1()
    {
        $users = $this->model('Users')->all();
        pre($users);
    }

}
