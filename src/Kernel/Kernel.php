<?php

namespace PureGlassAnalytics\Kernel;

use PureGlassAnalytics\Container\Container;
use PureGlassAnalytics\Config\Config;
use PureGlassAnalytics\HttpFoundation\Request;
use PureGlassAnalytics\Route\Route;
use PureGlassAnalytics\Route\RouteQuery;

class Kernel
{
	protected $container;

	public function __construct($environment)
	{
		// create application Container (currently Singleton)
		$this->setContainer(Container::getInstance());

		// create apoplication Configuration
		$config = new Config();
		$config->setEnvironment($environment);

		// add Configuration service to container
		$this->getContainer()->set('config', $config);

		// add Kernel service to container
		$this->getContainer()->set('kernel', $this);
	}

	protected function setContainer(Container $container)
	{
		$this->container = $container;
		return $this;
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function initialize()
	{
		// create lazy loading services from conviguration
		$this->getContainer()->addRegistry($this->getContainer()->get('config')->get('service'));
	}

	public function resolve(Request $request)
	{
		// add Request service
		$this->getContainer()->set('request', $request);

		// create The Router query object
		$routeQuery = new RouteQuery();
		$routeQuery->setRequest($request);

		// create the Router
		$route = new Route();

		// resolve requested route
		return $route->resolve($routeQuery);
	}
}
