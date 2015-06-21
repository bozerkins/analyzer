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
		// create lazy loading services from conviguration
		$container->addRegistry($container->get('config')->get('services'));

		// get query parser
		$searcher = $query->makeSearcher();

		// get plugin name
		$plugin = $searcher->getPluginName();

		// get controller class
		$controller = $searcher->getControllerClass();

		// get controller method
		$method = $searcher->getControllerMethod();

		// invoke controller
		$response = $this->invoke($plugin, $controller, $method);

		// validate response
		if (!$response instanceof Response) {
			throw new \ErrorException('fucking awesome');
		}

		// return response
		return $response;
	}

	protected function invoke($plugin, $class, $method)
	{
		$className = 'PureGlassAnalytics\\Plugins\\' . $plugin . '\\Controller\\' . $class . 'Controller';
		$object = new $className();
		return $object->{$method}();
	}
}
