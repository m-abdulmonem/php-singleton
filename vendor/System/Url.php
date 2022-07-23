<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 21/06/17
 * Time: 08:12 م
 */

namespace System;


class Url
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    private $app;


    /**
     * Url constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
     *
     * @param string $link
     */
    public function url($link){
       echo $this->app->requset->baseUrl();
    }


}