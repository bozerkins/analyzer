<?php

require_once __DIR__ . '/bootstrap.php';

use PureGlassAnalytics\HttpFoundation\Request;

// create the Request object
$request = Request::createFromGlobals();

// resolve the route
$response = $kernel->resolve($request);

// send the result
$response->send();
