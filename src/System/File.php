<?php

namespace Mabdulmonem\System;


class File
{
    /**
     * OS DIRECTORY_SEPARATOR
     * const $DS
     */
    const DS = DIRECTORY_SEPARATOR;
    /**
     *  Root Path
     *
     * @var string
     */
    private $root;

    /**
     * Constructor
     * @param string $root
     */
    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * Determined Weather the Given Path File exists
     *
     * @param string $file
     * @return boolean
     */
    public function exists($file)
    {
        return file_exists($this->to($file));
    }

    /**
     * Require The Given File
     * @param string $file
     * @return void
     */
    public function require($file)
    {
        return require $this->to($file);
    }

    /**
     * generate Vendor Path
     *
     * @param string $path
     * @return string
     */
    public function toVendor($path)
    {
        return $this->to('src/'.$path);
    }

    public function to($path)
    {
        return $this->root . static::DS . str_replace(['/','\\'],static::DS, $path);
    }
}