<?php

namespace System;


class Loader
{
    /**
     * Application Object
     *
     * @var \System\Application
     */
    private $app;
    /**
     * Controllers Container
     *
     * @var array
     */
    private $controllers = [];
    /**
     * Models Container
     *
     * @var array
     */
    private $models = [];


    /**
     * Loader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        //trigger This Class In Application Class
        $this->app = $app;
    }

    /**
     * Call The Given Controller With The Given Method
     * and pass The Given arguments to the Controller method
     * @param string $controller
     * @param string $method
     * @param array $argument
     * @return mixed
     */
    public function action(string $controller, string $method, array $argument)
    {
        $object = $this->controller($controller);
        return call_user_func([$object,$method], $argument);
    }
    /**
     * Call The Given Controller
     *
     * @param string $controller
     * @return object
     */
    public function controller($controller)
    {
        $controller = $this->getControllerName($controller);
        if (!$this->hasController($controller)){
            $this->newController($controller);
        }
        return $this->getController($controller);
    }

    /**
     * Determine if the given class|exists
     * in the controller container
     *
     * @param string $controller
     * @return boolean
     */
    private function hasController($controller)
    {
        return array_key_exists($controller,$this->controllers);
    }

    /**
     * Create New Object For The Given Controller And Store It
     * in controller Container
     *
     * @param $controller
     * @return void
     */
    private function newController($controller)
    {
        $object = new $controller($this->app);
        $this->controllers[$controller] = $object;
    }

    /**
     * get The controller Object
     *
     * @param string $controller
     * @return object
     */
    private function getController($controller)
    {
        return $this->controllers[$controller];
    }

    /**
     * get Full Controller Name From given Controller
     *
     * @param string $controller
     * @return string
     */
    private function getControllerName($controller)
    {
        $controller .= 'Controller';
        $controller = 'App\\Controllers\\'.$controller;
        return str_replace('/','\\',$controller);
    }

/*
    ##################################################################################################
    #                                                                                                #
    #                                        Model Scope                                             #
    #                                                                                                #
    ##################################################################################################
*/
    /**
     * Call The Given Model
     *
     * @param string $model
     * @return object
     */
    public function model($model)
    {
        $model = ucfirst($model);
        $model = $this->getModelName($model);
        if (!$this->hasModel($model)){
            $this->newModel($model);
        }
        return $this->getModel($model);
    }

    /**
     * Determine if the given class|exists
     * in the controller container
     *
     * @param string $model
     * @return boolean
     */
    private function hasModel($model)
    {
        return array_key_exists($model,$this->models);
    }

    /**
     * Create New Object For The Given Model And Store It
     * in controller Container
     *
     * @param $model
     * @return void
     */
    private function newModel($model)
    {
        $object = new $model($this->app);
        $this->models[$model] = $object;

    }

    /**
     * get The Model Object
     *
     * @param string $model
     * @return object
     */
    private function getModel($model)
    {
        return $this->models[$model];
    }

    /**
     * get Full Model Name From given Model
     *
     * @param string $model
     * @return string
     */
    private function getModelName($model)
    {
        $model .= 'Model';
        $model  = 'App\\Models\\'.$model;
        return str_replace('/','\\',$model);
    }


}