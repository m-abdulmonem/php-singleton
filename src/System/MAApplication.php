<?php


namespace Mabdulmonem\System;

use Mabdulmonem\System\File;
use Mabdulmonem\System\Session;
use Mabdulmonem\System\Http\Request;
use Mabdulmonem\System\Http\Response;

/**
 * @property Response $response
 * @property Session $session
 * @property Request $request
 * @property File $file
 * @property Route $route
 */
class MAApplication
{
    /**
     * Container
     *
     * @var array
     */
    private array $container = [];

    /**
     * Application  Instance
     *@var static instance
     */
    private static  $instance;


    /**
     * Constructor
     *
     * @param File|null $file
     */
    public function __construct(?File $file = null)
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
     * @throws \Exception
     * @var
     */
    public function run(): void
    {
        $this->session->start();
        $this->request->prepareUrl();
        $this->file->require('App/index.php');
        
        if ($this->route->getProperRoute()) {
            list($controller,$action,$arguments) = $this->route->getProperRoute();
            $output = (string) $this->load->action($controller,$action,$arguments);
            $this->response->setOutput($output);
            $this->response->send();
        }else{
//            dd($this->route->getProperRoute());
            throw new \Exception("404");
        }
    }

    /**
     * @param File|null $file
     * @return MAApplication
     */
    public static function getInstance(?File $file = null): MAApplication
    {
        if (is_null(static::$instance)){
            static::$instance = new static($file);
        }
        return static::$instance;
    }
    /**
     * Load Helpers File
     */
    private function loadHelpers(): void
    {
        $this->file->require('src/Helpers.php');
    }

    /**
     * AutoLoad Class 
     *
     * @return void
     */
    private function registerClasses(): void
    {
        spl_autoload_register([$this,'load']);
    }
    /**
     * Load Class Through Autoload
     *
     * @param string $class
     * @return void
     */
    public function load(string $class)
    {
        if (str_starts_with($class, 'App')){
           $file = $class.'.php';
        } else{
            // get The Class From Vendor
            $file = 'src/' . $class.'.php';
        }
        if ($this->file->exists($file)){
            $this->file->require($file);
        }
    }

    /**
     * get Shared Value
     *
     * @param string|null $key
     * @return mixed
     */
    public function get(?string $key): mixed
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
    public function isSharing(string $key): bool
    {
        return isset($this->container[$key]);
    }
    /**
     * get Shared Value dynamically
     *
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }

    /**
     * get All Core Classes With Its Aliases
     *
     * @return array
     */
    private function coreClasses(): array
    {
        return [
            'request'     => 'Mabdulmonem\\System\\Http\\Request',
            'response'    => 'Mabdulmonem\\System\\Http\\Response',
            'session'     => 'Mabdulmonem\\System\\Session',
            'cookie'      => 'Mabdulmonem\\System\\Cookie',
            'load'        => 'Mabdulmonem\\System\\Loader',
            'html'        => 'Mabdulmonem\\System\\Html',
            'db'          => 'Mabdulmonem\\System\\Database',
            'view'        => 'Mabdulmonem\\System\\View\\ViewFactory',
            'route'       => 'Mabdulmonem\\System\\Route',
            'url'         => 'Mabdulmonem\\System\\Url'
        ];
    }

    /**
     * Share Given Key|Value Through Application
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function share(string $key, mixed $value): void
    {
        $this->container[$key] = $value;
    }

    /**
     * @param $alias
     * @return bool
     */
    private function isCoreAlias($alias): bool
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