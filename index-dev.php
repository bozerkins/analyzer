<?php

require_once __DIR__ . '/vendor/autoload.php';

use PureGlassAnalytics\HttpFoundation\Request;
use PureGlassAnalytics\Route\Route;
use PureGlassAnalytics\Route\RouteQuery;

// create the Request object
$request = Request::createFromGlobals();

// create The Router query object
$routeQuery = new RouteQuery();
$routeQuery->setRequest($request);

// create the Router
$route = new Route();

// resolve requested route
$response = $route->resolve('development', $routeQuery);

// send the result
$response->send();
