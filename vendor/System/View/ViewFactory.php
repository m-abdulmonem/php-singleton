<?php
namespace System\View;


use System\Application;
class ViewFactory
{

    /**
     * Application object
     *
     * @var \System\Application
     */
    private $app;

    /**
     * ViewFactory constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Render View Path
     *
     * @param string $viewPath
     * @param array $data
     * @return View
     */

    public function render( $viewPath,array $data = [])
    {
        return new View($this->app->file,$viewPath,$data);
    }


}