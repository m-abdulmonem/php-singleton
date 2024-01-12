<?php

namespace Mabdulmonem\Controllers;

use Mabdulmonem\System\Controller;


class ErrorController extends Controller
{

    public function index(): string
    {
        return $this->view->render('main-layout/error/404');
    }

}