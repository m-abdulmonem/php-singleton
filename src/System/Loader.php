<?php

namespace Mabdulmonem\System;


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
     * @param MAApplication $app
     */
    public function __construct(MAApplication $app)
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
     * @throws \Exception
     */
    public function action(string $controller, string $method, array $argument): mixed
    {
        $object = $this->controller($controller);
        return call_user_func([$object,$method], $argument);
    }

    /**
     * Call The Given Controller
     *
     * @param string $controller
     * @return object
     * @throws \Exception
     */
    public function controller(string $controller): object
    {

        try {
            $controller = $this->getControllerName($controller);


            if (!$this->hasController($controller)){

                $this->newController($controller);
            }
            return $this->getController($controller);
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Determine if the given class|exists
     * in the controller container
     *
     * @param string $controller
     * @return boolean
     */
    private function hasController(string $controller): bool
    {
        return array_key_exists($controller,$this->controllers);
    }

    /**
     * Create New Object For The Given Controller And Store It
     * in controller Container
     *
     * @param $controller
     * @return void
     * @throws \Exception
     */
    private function newController($controller): void
    {
        if (class_exists($controller)){

            $object = new $controller($this->app);

            $this->controllers[$controller] = $object;
        }else{
            throw new \Exception("$controller Doest Exists");
        }
    }

    /**
     * get The controller Object
     *
     * @param string $controller
     * @return object
     */
    private function getController(string $controller): object
    {
        return $this->controllers[$controller];
    }

    /**
     * get Full Controller Name From given Controller
     *
     * @param string $controller
     * @return string
     */
    private function getControllerName(string $controller): string
    {
        if(str_contains($controller, 'Controller')){
            return $controller;
        }

        $controller .= 'Controller';
//        $controller = 'Mabdulmonem\\Controllers\\'.$controller;
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
    public function model(string $model): object
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
    private function hasModel(string $model): bool
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
    private function newModel($model): void
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
    private function getModel(string $model): object
    {
        return $this->models[$model];
    }

    /**
     * get Full Model Name From given Model
     *
     * @param string $model
     * @return string
     */
    private function getModelName(string $model): string
    {
        $model .= 'Model';
        $model  = 'App\\Models\\'.$model;
        return str_replace('/','\\',$model);
    }


}