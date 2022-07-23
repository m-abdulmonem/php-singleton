<?php

namespace System;


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
     * @param Application $app
     */
    public function __construct(Application $app)
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