<?php

namespace PureGlassAnalytics\Router;

use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\Config\Config;
use PureGlassAnalytics\Container\Container;

class Router
{
	public function resolve($environment, RouterQuery $query)
	{
		// create apoplication Configuration
		$config = new Config();
		$config->setEnvironment($environment);

		// create application Container (currently Singleton)
		$container = Container::getInstance();
		// add Configuration service to container
		$container->set('config', $config);
		// create lazy loading services from conviguration
		$container->addRegistry($container->get('config')->get('services'));



		throw new \ErrorException('Write ROUTER LOGICS');

		$response = new Response('Default message');
		return $response;
	}
}
