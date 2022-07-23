<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 02:50 م
 */

namespace System;


use System\Http\Request;

class Route
{

    /**
     * Application 
     *
     * @var \System\Application
     */
    private $app;

    /**
     * Routes Container
     *
     * @var array
     */
    private $routes = [];

    /**
     * Not Found Url
     *
     * @var string
     */
    private $notFound;
    /**
     * Route constructor.
     * @param Application $app
     */

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Set New Route
     *
     * @param string $url
     * @param string $action
     * @param string $requestMethod
     * @return void
     */
    public function set($url,$action,$requestMethod = "GET")
    {
        $route = [
          'url'       => $url,
          'pattern'   => $this->generatepattern($url),
          'action'    => $this->getAction($action),
          'method'    => strtoupper($requestMethod)
        ];
        $this->routes[] = $route;
    }

    /**
     * generate Regular Expression Url
     *
     * @param  string $url
     * @return string
     */
    private function generatePattern(string $url)
    {
        $pattern = "#^";

        $pattern .= str_replace([':text',':id'],['([a-zA-Z0-9-]+)','(\d+)'],$url);

        $pattern .= "$#";

        return $pattern;
    }

    /**
     *  get Proper Action
     *
     * @param string  $action
     * @return  string
     */
    private function getAction($action)
    {
        $action = str_replace('/','\\',$action);
        return strpos($action , "@") !== false ? $action : $action . "@index";
    }

    /**
     * Set Not Found
     * @param $url
     * @return void
     */
    public function notFound($url)
    {
        $this->notFound = $url;
    }

    public function getProperRoute()
    {
        foreach ($this->routes as $key => $route){

            if ($route['url'] == $this->app->request->url()) {
                $arguments = $this->getArgumentsFrom($route['pattern']);
                list($controller,$method) = explode("@",$route['action']);
                return [$controller, $method ,$arguments];
            }
            continue;
            // elseif ($route['url'] != $this->app->request->url()) {
            //     die("404 Page Not found");
            // }else{
            //     contiune;
            // }
        }
    }

    /**
     * @param $pattern
     * @return boolean
     */
    private function isMatching($pattern = null)
    {
//        return $pattern === $this->app->request->url();
        return preg_match($pattern,$this->app->request->url()) > 0;
    }

    /**
     * @param $pattern
     * @return bool
     */
    private function getArgumentsFrom($pattern)
    {
        preg_match($pattern,$this->app->request->url(),$matches);
        array_shift($matches);
        return $matches;
    }

}