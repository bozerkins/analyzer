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

		// get query parser
		$parser = $query->makeParser();

		// get plugin name
		$plugin = $parser->getPluginName();

		// get controller class
		$controller = $parser->getControllerClass();

		// get controller method
		$method = $parser->getControllerMethod();

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
