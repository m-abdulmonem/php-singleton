<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 02:50 م
 */

namespace Mabdulmonem\System;


use Mabdulmonem\System\Http\Request;

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
     * @param MAApplication $app
     */

     private string $current;

    public function __construct(MAApplication $app)
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
    public function set(string $url, string|array $action, string $requestMethod = "GET"): void
    {
        $route = [
          'url'       => $url,
          'pattern'   => $this->generatepattern($url),
          'action'    => $this->getAction($action),
          'method'    => strtoupper($requestMethod),
        ];
        $this->current = $url;
        $this->routes[] = $route;
    }

    
    public function get(string $url, $action)
    {
        $this->set($url, $action, "GET");
        return $this;
    }

    public function post(string $url, $action)
    {
        $this->set($url, $action, "POST");
        return $this;
    }
    
    public function delete(string $url, $action)
    {
        $this->set($url, $action, "delete");
        return $this;
    }
    
    
    public function any(string $url, $action)
    {
        $this->set($url, $action, "any");
        return $this;
    }


    public function middleware(string $middleware)
    {
        foreach ($this->routes as $key => $route) {
            if ($route['url'] == $this->current){
                $this->routes[$key]['middleware'] = $middleware;
            }
        }
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
     * @param array|string $action
     * @return  string
     */
    private function getAction(array|string $action): string
    {
        if (is_array($action)){
            return implode('@',$action);
        }
        $action = str_replace('/','\\',$action);
        return str_contains($action, "@") ? $action : $action . "@index";
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

    public function getProperRoute() : mixed
    {
        foreach ($this->routes as $key => $route){

            if ($this->isMatching($route['pattern'])) {
                if($middleware = array_get(config('middleware')['middlewares'], array_get($route,'middleware'))){

//                    $this->app->session->
                    return (new $middleware)->handle($this->app->request, function() use ($route){
                        $arguments = $this->getArgumentsFrom($route['pattern']);
                        list($controller, $method) = explode("@", $route['action']);
                        return [$controller, $method, $arguments];
                    });
                }
               
                $arguments = $this->getArgumentsFrom($route['pattern']);
                list($controller, $method) = explode("@", $route['action']);
                return [$controller, $method, $arguments];
               
            }
            continue;
        }
        return [];
    }

    /**
     * @param $pattern
     * @return boolean
     */
    private function isMatching($pattern = null)
    {
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