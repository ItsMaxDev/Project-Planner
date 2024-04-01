<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Controllers');

// routes for the project endpoint
$router->get('/api/projects', 'ProjectController@getOwn');
$router->get('/api/projects/all', 'ProjectController@getAll');
$router->get('/api/projects/(\d+)', 'ProjectController@getOne');
$router->post('/api/projects', 'ProjectController@create');
$router->put('/api/projects/(\d+)', 'ProjectController@update');
$router->delete('/api/projects/(\d+)', 'ProjectController@delete');

// routes for the user endpoint
$router->post('/api/login', 'UserController@login');
$router->post('/api/register', 'UserController@register');
$router->get('/api/verifytoken', 'UserController@verifyTokenValidity');

// Run it!
$router->run();