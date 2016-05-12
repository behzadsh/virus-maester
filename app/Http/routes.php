<?php

/** @var Router $router */

use Illuminate\Routing\Router;

$router->get('/', function () {
    return view('home');
});

$router->post('/file', ['as' => 'file', 'uses' => 'ScanController@file']);
$router->post('/url', ['as' => 'url', 'uses' => 'ScanController@url']);