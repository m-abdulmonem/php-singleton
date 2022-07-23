<?php

if (! function_exists('pre')){

    /**
     * This is The Pre
     *
     * @param $var
     * @return mixed
     */
    function pre($var = null){
        echo "<pre style='background: #000; color: #fff; padding: 15px;font-size: 16px'>";
        var_dump($var);
        echo "</pre>";
        exit();
    }

}

if (! function_exists('array_get')){

    /**
     *  get the Value From The Given Array For The Given Key if Found
     * otherwise get The Default value
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return null
     */
    function array_get($array,$key,$default = null){
        return isset($array[$key]) ? $array[$key] : $default;
    }
}

if (! function_exists('_e')){


    /**
     * Filter Value From Special Html tags
     *
     * @param $value
     * @return string
     */
    function _e($value){
        return htmlspecialchars($value);
    }
}
if (! function_exists("_404")){

    function _404(){
        echo "404";
        exit();
    }
}


























