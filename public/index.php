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

$router->addRoute('/^\/supplier\/?$/', 'SupplierController', 'index', Method::GET);
$router->addRoute('/^\/supplier\/(\d+)\/?$/', 'SupplierController', 'show', Method::GET);
$router->addRoute('/^\/supplier\/?$/', 'SupplierController', 'create', Method::POST);
$router->addRoute('/^\/supplier\/(\d+)\/?$/', 'SupplierController', 'update', Method::PUT);
$router->addRoute('/^\/supplier\/(\d+)\/?$/', 'SupplierController', 'delete', Method::DELETE);

$router->addRoute('/^\/register\/?$/', 'AuthController', 'register', Method::POST);
$router->addRoute('/^\/login\/?$/', 'AuthController', 'login', Method::POST);

$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri);

