<?php

//require_once __DIR__ . '/src/System/Application.php';
//require_once __DIR__ . '/src/System/File.php';
//require_once __DIR__ . '/src/System/Http/Request.php';
//use Mabdulmonem\System\Application;
//use Mabdulmonem\System\File;

require_once __DIR__ . '/vendor/autoload.php';

use Mabdulmonem\System\{File,MAApplication};

$file = new File(__DIR__);

$app = MAApplication::getInstance($file);


//try {
try {
    $app->run();
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}
//} catch (Exception $e) {
//    throw new Exception('500 Server error');
//}