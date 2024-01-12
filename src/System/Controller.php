<?php

namespace Mabdulmonem\System;


use Mabdulmonem\System\View\View;

/**
 * @property mixed $load
 * @property View $view
 */
abstract class Controller
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    protected $app;


    /**
     * Controller constructor.
     *
     * @param MAApplication $app
     */
    public function __construct(MAApplication $app)
    {
        $this->app = $app;
    }

    /**
     * Call Shared Application object Dynamically
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->app->get($key);
    }

    /**
    */
    public function model($modelName)
    {
        return $this->load->model($modelName);
    }

}