<?php

namespace PureGlassAnalytics\Route;

use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\Config\Config;
use PureGlassAnalytics\Container\Container;

class Route
{
	public function resolve($environment, RouteQuery $query)
	{
		// create apoplication Configuration
		$config = new Config();
		$config->setEnvironment($environment);

		// create application Container (currently Singleton)
		$container = Container::getInstance();

		// add Configuration service to container
		$container->set('config', $config);

		// add Request service
		$container->set('request', $query->getRequest());

		// create lazy loading services from conviguration
		$container->addRegistry($container->get('config')->get('service'));

		// run query search
		$query->search();

		// check if controller found
		if (!$query->getCallable()) {
			throw new \ErrorException('Path not found: ' . $query->getRequestedPath());
		}

		// invoke controller
		$response = $this->invoke($query->getCallable());

		// validate response
		if (!$response instanceof Response) {
			throw new \ErrorException('$response variable must be and instance of Response class. Controller returned: ' . gettype($response));
		}

		// return response
		return $response;
	}

	protected function invoke($callable)
	{
		$callable[0] = 'PureGlassAnalytics\\Package\\' . $callable[0];
		$controller = new $callable[0]();
		return $controller->{$callable[1]}();
	}
}
