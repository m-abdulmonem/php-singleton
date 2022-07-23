<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 11:23 ص
 */

namespace System\Http;


class Request
{

    /**
     * Url
     * @var string $url
     */
    private $url;

    /**
     * Base Url
     *
     * @var string baseUrl
     */
    private $baseUrl;
    /**
     * Prepare Url
     *
     * @return array
     */
    public function prepareUrl()
    {
        $script =  dirname($this->server('SCRIPT_NAME'));
        $requestUri = $this->server('REQUEST_URI');
        if (strpos($requestUri ,'?') !== false){
            list($requestUri, $queryString) = explode('?',$requestUri);
        }


        $this->url = preg_replace('#^'.$script.'#' ,'',$requestUri);
        $this->baseUrl = $this->server('REQUEST_SCHEME') . '://' . $this->server('HTTP_HOST') . $script;
    }

    /**
     * Super Global $_GET Variable
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($_GET,$key,$default);
    }

    /**
     *  Super Global $_POST Variable
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return array_get($_POST,$key,$default);
    }

    /**
     * Super Global $_SERVER Variable
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function server($key, $default =null)
    {
        return array_get($_SERVER,$key,$default);
    }

    /**
     * The Request Type [get or post]
     *
     * @return mixed
     */
    public function method()
    {
        return $this->server('REQUEST_METHOD');
    }

    /**
     * Base Url Method
     *
     * @return mixed
     */
    public function baseUrl()
    {
        return $this->baseUrl;
    }

    /**
     *
     *
     * @return mixed
     */
    public function url()
    {
        return $this->url;
    }

}