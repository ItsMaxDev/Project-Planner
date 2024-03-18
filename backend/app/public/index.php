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
$router->get('/projects', 'ProjectController@getAll');
$router->get('/projects/(\d+)', 'ProjectController@getOne');
$router->post('/projects', 'ProjectController@create');
$router->put('/projects/(\d+)', 'ProjectController@update');
$router->delete('/projects/(\d+)', 'ProjectController@delete');

// routes for the user endpoint
$router->get('/users', 'UserController@getAll');
$router->get('/users/(\d+)', 'UserController@getOne');
$router->post('/users', 'UserController@create');
$router->put('/users/(\d+)', 'UserController@update');
$router->delete('/users/(\d+)', 'UserController@delete');

// Run it!
$router->run();