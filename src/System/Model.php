<?php

namespace Mabdulmonem\System;

abstract class Model extends ModelHelper
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    protected $app;

    private static $a;

    protected $table;
    protected $key;
    protected $columns;

    /**
     * Controller constructor.
     *
     * @param MAApplication $app
     */
    public function __construct(MAApplication $app)
    {
        $this->app = $app;
        self::$a = $app;
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



    public function create(?array $data = [])
    {
        return $this->data($data)->insert($this->table);
    }

    public function all()
    {

        return $this->fetchAll($this->table);
    }

    public function __toString() {
        $data = $this->all();
        if (is_array($data) || is_object($data)) {
            return json_encode($data);
        } else {
            return ''; // or some default string representation
        }
    }


}