<?php


if (! function_exists('pre')){

    /**
     * This is The Pre
     *
     * @param $var
     * @return mixed
     */
    function pre(...$var){
  
        foreach ($var as $value) {
            echo "<pre style='background: #000; color: #fff; padding: 15px;font-size: 16px'>" . ($e = new Exception)->getFile(). ":{$e->getLine()}   ";
            print_r($value);
            echo "</pre>";
        }
  
        exit(500);
    }

}


function config(string $config){
    global $app;
    return $app->file->require("config/$config.php"); 
}

if (!function_exists('dd')) {

    /**
     * This is The Pre
     *
     * @param $var
     * @return mixed
     */
    function dd(...$var)
    {
        pre($var);
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



if (!function_exists("redirect")) {

    function redirect(string $url = "/")
    {
        global $app;

        return header("Location: {$app->request->baseUrl()}/$url");
    }
}


if (!function_exists("json")) {

    function json(mixed $data, string $message = null,string $status = 'success'): false|string
    {
        global $app;

        return $app->response->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ]);
    }
}

























