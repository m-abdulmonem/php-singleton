<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 10:34 ص
 */

namespace System;


class Cookie
{

    /**
     * @var \System\Application
     */
    private $app;


    /**
     * Cookie constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }


    /**
     * set Cookie
     *
     * @param $key
     * @param $value
     * @param int $hour
     */
    public function set($key, $value, $hour = 60)
    {
        setcookie($key,$value,time() + $hour * 3600,'','',false,true);
    }

    /**
     * get Cookie
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        return array_get($_COOKIE,$key,$default);
    }

    /**
     * Check If The Cookie Is exists
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key,$_COOKIE);
    }

    /**
     * Remove Cookie
     *
     * @param $key
     */
    public function remove($key)
    {
        $this->set($key,'',-1);
        unset($_COOKIE[$key]);
    }

    /**
     * Destroy Cookie
     */
    public function destroy()
    {
        foreach (array_keys($this->all()) as $key){
            $this->remove($key);
        }
        unset($_COOKIE);
    }

    /**
     * Get All Cookies
     * @return array
     */
    public function all()
    {
        return $_COOKIE;
    }

}