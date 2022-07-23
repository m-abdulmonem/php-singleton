<?php

namespace System\View;

use System\File;

class View implements ViewInterFace
{
    /**
     * File Object
     * @var \System\File
     */
    private $file;

    /**
     * View Path
     *
     * @var string
     */
    private $viewPath;
    /**
     * Passed data Variables To View Path
     *
     * @var array
     */
    private $data = [];

    /**
     * The Output From View File
     *
     * @var string
     */
    private $output;

    /**
     * View constructor.
     *
     * @param File $file
     * @param string $viewPath
     * @param array $data
     */
    public function __construct(File $file, $viewPath, array $data = [])
    {

        $this->file = $file;
        $this->preparePath($viewPath);
        $this->data = $data;
        
    }

    /**
     * Prepare View Path
     *
     * @param string $viewPath
     * @return void
     */
    private function preparePath( $viewPath){
        $file = 'App/Views/'.$viewPath.'.php';
        $this->viewPath = $this->file->to($file);
        if (! $this->viewFileExists($file)){
            die("Sorry! 404 Not Found ");
        }

    }

    /**
     * Determine If View File Is Exists
     * @param $file
     * @return bool
     */
    private function viewFileExists($file){
        return $this->file->exists($file);
    }

    /**
     * Get View Output
     *
     * @return string
     */
    public function getOutput()
    {
        if (is_null($this->output)){
            ob_start();
            extract($this->data);
                require  $this->viewPath;
            $this->output = ob_get_clean();
        }
        return $this->output;
    }

    /**
     * Convert View Object To String
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getOutput();
    }
}