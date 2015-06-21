<?php

require_once __DIR__ . '/vendor/autoload.php';

use PureGlassAnalytics\HttpFoundation\Request;
use PureGlassAnalytics\Router\Router;
use PureGlassAnalytics\Router\RouterQuery;

// create the Request object
$request = Request::createFromGlobals();

// create The Router query object
$routerQuery = new RouterQuery();
$routerQuery->setRequest($request);

// create the Router
$router = new Router();

// resolve requested route
$response = $router->resolve('development', $routerQuery);

// send the result
$response->send();
