<?php
namespace Mabdulmonem\Controllers\Settings;
use System\Controller;

class SettingsController extends Controller
{

    /**
     *
     */
    public function index()
    {
        return $this->view->render("Settings/settings");
    }

    public function fun(){
        echo "ok";
    }

}