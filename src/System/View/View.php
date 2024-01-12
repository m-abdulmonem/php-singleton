<?php

namespace Mabdulmonem\System\View;

use Exception;
use Mabdulmonem\System\File;

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
     * @throws Exception
     */
    public function __construct(File $file, string $viewPath, array $data = [])
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
     * @throws Exception
     */
    private function preparePath(string $viewPath): void
    {
        ;
        $this->viewPath = $this->file->to($file = 'App/Views/'.$viewPath.'.ma.php');
        if (! $this->viewFileExists($file)){
            throw new Exception("Template file does not exist: {$this->file}");
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
    public function getOutput(): string
    {
        if (is_null($this->output)){
            ob_start();
            extract($this->data);
                require  $this->viewPath;
            $this->output = ob_get_clean();
        }
        return $this->output;
    }


    public function render(): string
    {
//        if (!file_exists($this->file)) {
//            throw new Exception("Template file does not exist: {$this->file}");
//        }
        return $this->getOutput();
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