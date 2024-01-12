<?php


$app = \Mabdulmonem\System\MAApplication::getInstance();

$app->route->set('/','Home');
$app->route->set('/settings','Settings/Settings');
$app->route->set('/user',[\App\Controllers\HomeController::class , 'joker']);
$app->route->get('/test','Home@model1')->middleware("test");
$app->route->set('/posts/:text/:id','Posts/Post');
$app->route->set('/t','Home@t');
$app->route->set('/login','Auth/Login');
$app->route->set('/hi','Login1');
//$app->route->set('');

$app->route->get('/call', [\App\Controllers\Auth\LoginController::class, 'test']);

$app->route->set('/404','Error');
$app->route->NotFound('/404');
