<?php
namespace Mabdulmonem\System\View;


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
     * @throws \Exception
     */

    public function render(string $viewPath, array $data = []): View
    {
        return new View($this->app->file,$viewPath,$data);
    }


}