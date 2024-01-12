<?php
namespace Mabdulmonem\System\View;

interface ViewInterFace
{

    /**
     * Get View Output
     *
     * @return string
     */
    public function getOutput();


    /**
     * Convert View Object To String
     *
     * @return string
     */
    public function __toString();
}