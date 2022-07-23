<?php

namespace System;

abstract class Model
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    protected $app;


    protected $table;
    protected $key;
    protected $columns;

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
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->app->db,$method],$args);
    }



    public function all()
    {
        return $this->fetchAll($this->table);
    }



}