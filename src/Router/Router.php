<?php

namespace PureGlassAnalytics\Router;

use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\Config\Config;
use PureGlassAnalytics\Container\Container;

class Router
{
	public function resolve($environment, RouterQuery $query)
	{
		$config = new Config();
		$config->setEnvironment($environment);

		$container = Container::getInstance();
		$container->set('config', $config);
		$container->addRegistry($container->get('config')->get('services'));

		$container->get('database');

		throw new \ErrorException('Write ROUTER LOGICS');



		$response = new Response('Default message');
		return $response;
	}
}
