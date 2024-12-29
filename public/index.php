<?php
use Framework\Session;

require __DIR__  . '/../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;

// instatiate the router
$router = new Router();
Session::start();
// Get routes
$routes = require basePath('routes.php');

// Get current uri and method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route the request
$router->route($uri);



