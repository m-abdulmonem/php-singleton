<?php

require_once __DIR__ . '/vendor/System/Application.php';
require_once __DIR__ . '/vendor/System/File.php';

use System\File;
use System\Application;

$file = new File(__DIR__);

$app = Application::getInstance($file);


$app->run();