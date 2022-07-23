<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 21/06/17
 * Time: 01:30 م
 */

namespace System;


class Html
{
    /**
     * Application object
     *
     * @var \System\Application
     */
    private $app;

    /**
     * Site Title
     *
     * @var string
     */
    private  $title;
    /**
     * Site description
     *
     * @var string
     */
    private $description;
    /**
     * Site KeyWord
     *
     * @var $keyword
     */
    private $keyword;

    /**
     * Html constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * get site title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}