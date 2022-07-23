<?php


namespace System;


class Application
{
    /**
     * Container
     *
     * @var array
     */
    private $container = [];

    /**
     * Application  Instance
     *@var static instance
     */
    private static $instance;
    /**
     * Constructor
     *
     * @param File $file
     */
    private function __construct(File $file)
    {
        $this->share("file",$file);

        $this->registerClasses();
        $this->loadHelpers();
    }


    public function __call( $method , $arguments = array() )
    {
        if( isset( $this->$method ) ) // or anything else
        {
            return $this->$method; // or anything else
        }
        else
        {
            // restore fatal error
            trigger_error( sprintf( 'Call to undefined method %s::%s()' , get_class( $this ) , $method ) , E_USER_ERROR );
        }
    }


    /**
     * Run the Application
     * 
     * @var 
     */
    public function run()
    {
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->require('App/index.php');
        
        if ($this->route->getProperRoute()) {
            list($controller,$action,$arguments) = $this->route->getProperRoute();
            $output =(string) $this->load->action($controller,$action,$arguments);
            $this->response->setOutput($output);
            $this->response->send();
        }else{
            echo "404";
        }
    }

    /**
     * @param null|string $file
     * @return Application
     */
    public static function getInstance($file = null)
    {
        if (is_null(static::$instance)){
            static::$instance = new static($file);
        }
        return static::$instance;
    }
    /**
     * Load Helpers File
     */
    private function loadHelpers()
    {
        $this->file->require('vendor/Helpers.php');
    }

    /**
     * AutoLoad Class 
     *
     * @return void
     */
    private function registerClasses()
    {
        spl_autoload_register([$this,'load']);
    }
    /**
     * Load Class Through Autoloading
     *
     * @param string $class
     * @return void
     */
    public function load(string $class)
    {
        if (strpos($class,'App') === 0){
           $file = $class.'.php';
        } else{
            // get The Class From Vendor
            $file = 'vendor/' . $class.'.php';
        }
        if ($this->file->exists($file)){
            $this->file->require($file);
        }
    }
    /**
     * get Shared Value
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (!$this->isSharing($key)){
            if ($this->isCoreAlias($key)){
                $this->share($key,$this->createNewCoreObject($key));
            } else{
                $this->file->to('Error/404.php');
            }
        }
        return $this->container[$key];
    }

    /**
     * Determine if The Given Key Exists
     *
     * @param string $key
     * @return boolean
     */
    public function isSharing(string $key)
    {
        return isset($this->container[$key]);
    }
    /**
     * get Shared Value dynamically
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * get All Core Classes With Its Aliases
     *
     * @return array
     */
    private function coreClasses()
    {
        return [
            'request'     => 'System\\Http\\Request',
            'response'    => 'System\\Http\\Response',
            'session'     => 'System\\Session',
            'cookie'      => 'System\\Cookie',
            'load'        => 'System\\Loader',
            'html'        => 'System\\Html',
            'db'          => 'System\\Database',
            'view'        => 'System\\View\\ViewFactory',
            'route'       => 'System\\Route',
            'url'         => 'System\\Url'
        ];
    }

    /**
     * Share Given Key|Value Through Application
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function share($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * @param $alias
     * @return bool
     */
    private function isCoreAlias($alias)
    {
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$alias]);
    }

    private function createNewCoreObject($alias)
    {
        $coreClasses = $this->coreClasses();
        $object = $coreClasses[$alias];
        return new $object($this);
    }


}