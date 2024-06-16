<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Enums\Method;
use Core\Router;

$router = new Router();
$router->addRoute('/^\/product\/?$/', 'ProductController', 'index', Method::GET);
$router->addRoute('/^\/product\/(\d+)\/?$/', 'ProductController', 'show', Method::GET);
$router->addRoute('/^\/product\/?$/', 'ProductController', 'create', Method::POST);
$router->addRoute('/^\/product\/(\d+)\/?$/', 'ProductController', 'update', Method::PUT);
$router->addRoute('/^\/product\/(\d+)\/?$/', 'ProductController', 'delete', Method::DELETE);

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);

