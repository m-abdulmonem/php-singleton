<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 10:34 ص
 */

namespace Mabdulmonem\System;


class Session
{

    /**
     * Application Object
     * @var \System\Application
     */
    private $app;


    /**
     * Session constructor.
     * @param MAApplication $app
     */
    public function __construct(MAApplication $app)
    {
        $this->app = $app;
    }

    /**
     * Start The Session
     *
     */
    public function start(): void
    {
        ini_set('session.use_only_cookies',1);

        if (!session_id()){
            session_start();
        }
    }

    /**
     * Set Session
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
         $_SESSION[$key] =  $value;
    }

    /**
     * get Session
     *
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        return array_get($_SESSION,$key,$default);
    }

    /**
     * Check If The Key Are exists Or Not
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove Session By key
     *
     * @param $key
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     *  Return Session Value And Than Remove session key
     * @param $key
     * @return null
     */
    public function pull($key)
    {
        $value = $this->get($key);
        $this->remove($key);
        return $value;
    }

    /**
     * Destroy All Sessions
     */
    public function destroy()
    {
        session_destroy();
        unset($_SESSION);
    }

    /**
     * get All Sessions
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }



}