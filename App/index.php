<?php

use System\Application;

$app = Application::getInstance();

$app->route->set('/','Home');
$app->route->set('/user','Home@joker');
$app->route->set('/test','Home@model1');
$app->route->set('/posts/:text/:id','Posts/Post');
$app->route->set('/t','Home@t');
//$app->route->set('');

$app->route->set('/404','Error');
$app->route->NotFound('/404');
