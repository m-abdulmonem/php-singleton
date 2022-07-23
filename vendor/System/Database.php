<?php

namespace System;

use PDO;
use PDOException;

class Database
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    private $app;

    /**
     * PDO
     * @var \PDO
     */
    private static $connection;
    /**
     * Table Name
     *
     * @var string
     */
    private $table;
    /**
     * data Container
     * @var array
     */
    private $data = [];
    /**
     * Bindings Container
     *
     * @var array
     */
    private $bindings = [];
    /**
     * Where Container
     *
     * @var array
     */
    private $wheres = [];

    /**
     * get last data Inserted id
     * @var int
     */
    private $lastID;
    /**
     * Selects
     * @var array
     */
    private $selects = [];
    /**
     * Joins
     * @var array
     */
    private $joins = [];
    /**
     * Offset
     * @var int
     */
    private $offset;
    /**
     * Limit
     *
     * @var int
     */
    private $limit;
    /**
     * Total Rows
     *
     * @var int
     */
    private $rows = 0;
    /**
     * Order By
     *
     * @var array
     */
    private $orderBy = [];
    /**
     * Database constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        if (! $this->isConnected()){
           $this->connect();
        }
    }

    /**
     *
     * @return bool
     */
    private function isConnected()
    {
        return static::$connection instanceof PDO;
    }

    /**
     *
     * @return void
     */
    private function connect()
    {
       $data = $this->app->file->require('config.php');
       extract($data);
       $dsn = "mysql:host=".$server.";dbname=".$dbname;
       $user = $dbuser;
       $pass = $dbpass;
       try{
           static::$connection = new PDO($dsn,$user,$pass);
           static::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           static::$connection->exec("SET NAMES utf8");
       } catch (PDOException $e){
           $this->app->file->require("App/Error/ConnectionError.php");
       }
    }

    /**
     * @return PDO
     */
    public function connection()
    {
        return static::$connection;
    }


    /**
     * set The Table Name
     *
     * @param string $table
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;
        return$this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        return $this->table($table);
    }

    /**
     * The Data Will Be Stored In Database
     * @param $key
     * @param $value
     * @return $this
     */
    public function data($key, $value = null)
    {
        if (is_array($key)){
            $this->data = array_merge($this->data,$key);
            $this->addToBindings($key);
        }else {
            $this->data[$key] = $value;
            $this->addToBindings($value);
        }
        return$this;
    }


    /**
     * Insert data Method Into database
     *
     * @param string|null $table
     * @return $this
     */
    public function insert($table = null)
    {
        if ($table){
            $this->table($table);
        }

        $sql = "INSERT INTO " .$this->table . " SET ";
        $sql .= $this->setFields();
        $sql = rtrim($sql, ', ');
        $this->query($sql,$this->bindings);
        $this->lastID = $this->connection()->lastInsertId();
        $this->rest();
        return $this;
    }

    /**
     * update data In database
     *
     * @param string|null $table
     * @return $this
     */
    public function update($table = null)
    {
        if ($table){
            $this->table($table);
        }

        $sql = "UPDATE " .$this->table . " SET ";

        $sql .= $this->setFields();

        if ($this->wheres){
            $sql .= " WHERE " . implode(' ',$this->wheres);
        }
        $query = $this->query($sql,$this->bindings);
        $this->rows = $query->rowCount();
        $this->rest();
        return $this;
    }
    /**
     * delete data From database
     *
     * @param string|null $table
     * @return $this
     */
    public function delete($table = null)
    {
        if ($table){
            $this->table($table);
        }

        $sql = "DELETE FROM " .$this->table . "  ";

        $sql .= $this->setFields();

        if ($this->wheres){
            $sql .= " WHERE " . implode(' ',$this->wheres);
        }
        $query = $this->query($sql,$this->bindings);
        $this->rows = $query->rowCount();
        $this->rest();
        return $this;
    }


    /**
     * @param null $table
     * @return \stdClass | null
     */
    public function fetch($table = null)
    {
        if ($table) {
            $this->table($table);
        }
        $sql = $this->fetchStatement();
        $result = $this->query($sql,$this->bindings)->fetch();
        $this->rest();
        return $result;
    }

    /**
     * @param null $table
     * @return \stdClass| null| array
     */
    public function fetchAll($table = null)
    {
        if ($table) {
            $this->table($table);
        }
        $sql = $this->fetchStatement();
        $query = $this->query($sql,$this->bindings);
        $results = $query->fetchAll();
        $this->rows = $query->rowCount();
        $this->rest();
        return $results;
    }

    /**
     * Sum Total Rows
     *
     * @return int
     */
    public function count()
    {
        return $this->rows;
    }

    /**
     * Set Select Clause
     *
     * @param $select
     * @return $this
     */
    public function select($select)
    {
        $this->selects[] = $select;
        return $this;
    }

    /**
     * set Join Clause
     *
     * @param $join
     * @return $this
     */
    public function join($join)
    {
        $this->joins[] = $join;
        return $this;
    }

    public function orderBy($orderBy,$sort = "ASC")
    {
        $this->orderBy = [$orderBy,$sort];
        return $this;
    }

    /**
     * Set Limit And Offset
     *
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function limit($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset =$offset;
        return $this;
    }
    /**
     * @param $value
     */
    private function addToBindings($value)
    {
        if (is_array($value))
            $this->bindings = array_merge($this->bindings,array_values($value));
        else
            $this->bindings[] = _e($value);
    }

    /**
     * Execute Sql Statement
     *
     * @return \PDOStatement
     */
    public function query()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        if (count($bindings) && is_array($bindings[0])){
            $bindings = $bindings[0];
        }
       try{
           $query = $this->connection()->prepare($sql);
           foreach ($bindings as $key  => $value){
               $query->bindValue($key + 1, _e($value));
           }
           $query->execute();
           return $query;
       } catch (PDOException $e){
            die($e->getMessage());
       }
    }

    /**
     * get Last Data inserted ID
     * @return int
     */
    public function getLastID()
    {
        return $this->lastID;
    }

    /**
     *
     * @return $this
     */
    public function where()
    {
        $bindings = func_get_args();
        $sql = array_shift($bindings);
        $this->addToBindings($bindings);
        $this->wheres[] = $sql;
        return $this;
    }

    private function setFields(){
        $sql = '';
        foreach (array_keys($this->data) as $key ){
            $sql .= '`'.$key.'` = ? , ';
        }
        $sql = rtrim($sql, ', ');
        return $sql;
    }

    /**
     * @return string
     */
    private function fetchStatement(){
        $sql ="SELECT ";
        if ($this->selects){
            $sql .= implode(',',$this->selects);
        }else{
            $sql .="*";
        }
        $sql .= " FROM " . $this->table . ' ';

        if ($this->joins){
            $sql .= implode(' ', $this->joins);
        }

        if ($this->wheres){
            $sql .= ' WHERE ' . implode(' ',$this->wheres);
        }
        if ($this->limit){
            $sql .= " LIMIT " .$this->limit;
        }
        if ($this->offset){
            $sql .= " OFFSET " .$this->limit;
        }
        if ($this->orderBy){
            $sql .= " ORDER BY " . implode(' ',$this->orderBy);
        }
        return $sql;
    }

    /**
     *
     *
     *
     */
    private function rest(){
        $this->bindings = [];
        $this->wheres = [];
        $this->joins = [];
        $this->selects = [];
        $this->orderBy = [];
        $this->data = [];
        $this->table = null;
        $this->offset = null;
        $this->limit = null;
    }

}
