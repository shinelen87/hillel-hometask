<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Enums\Method;
use Core\Router;

$router = new Router();
$router->addRoute('/^\/test\/?$/', 'TestController', 'index', Method::GET);
$router->addRoute('/^\/test\/(\d+)\/?$/', 'TestController', 'show', Method::GET);
$router->addRoute('/^\/test\/?$/', 'TestController', 'create', Method::POST);
$router->addRoute('/^\/test\/(\d+)\/?$/', 'TestController', 'update', Method::PUT);
$router->addRoute('/^\/test\/(\d+)\/?$/', 'TestController', 'delete', Method::DELETE);

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);

