<?php

require_once __DIR__ . '/vendor/autoload.php';

use PureGlassAnalytics\Kernel\Kernel;

// create Kernel object
$kernel = new Kernel('development');

// intialize kernel
$kernel->initialize();

// return kernel
return $kernel;
