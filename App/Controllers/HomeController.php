<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Mabdulmonem\System\Controller;

function bytesToMB($bytes) {
    return round($bytes / 1024 / 1024, 2);
}

class HomeController extends Controller
{

    /**
     *
     */
    public function index(): void
    {
        echo "Welcome";
    }


    public function joker()
    {
//        echo bytesToMB(memory_get_usage()) . " MB \n";
//
//        for ($i = 0; $i < 1000; $i++) {
//            $this->model('users')->create([
//                "user" => "edkmew-$i",
//                "pass" => "cjwencm$i",
//                "email" => "4@4-$i.com"
//            ]);
//        }
        echo bytesToMB(memory_get_usage()) . " MB \n";

        //['users' => $this->model('users')->all()]
        $users = $this->model('users')->all();
        return json([
            'usage' => bytesToMB(memory_get_usage()) . " MB",
            'count' => count($users),
            'items' => $users
        ]);
//        return $this->view->render('Users/joker', $data);
    }

    public function t()
    {
        return $this->model1();
    }

    public function model1()
    {
        $users = $this->model('Users')->all();
        pre($users);
    }

}
