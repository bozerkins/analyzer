<?php

include(__DIR__ . '/../production/' . basename(__FILE__));

$database['dbhost'] = 'localhost';
$database['dbname'] = 'pure-glass-analytics';
$database['dbuser'] = 'root';
$database['dbpass'] = '';

return $database;
