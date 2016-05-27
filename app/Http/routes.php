<?php

/** @var Router $router */

use Illuminate\Routing\Router;

$router->get('/', function () {
    return view('home', ['title' => 'VirusMaester']);
});

$router->post('/file', ['as' => 'file', 'uses' => 'ScanController@file']);
$router->post('/url', ['as' => 'url', 'uses' => 'ScanController@url']);

$router->get('/file/{scan_id}', 'ScanController@fileReport');
$router->get('/url/{scan_id}', 'ScanController@urlReport');