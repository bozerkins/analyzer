<?php

namespace PureGlassAnalytics\Route;

use PureGlassAnalytics\HttpFoundation\Request;
use PureGlassAnalytics\Container\Container;

class RouteQuery
{
	protected $request;
	protected $package;
	protected $controller;
	protected $method;
	protected $callable;

	public function setRequest(Request $request)
	{
		$this->request = $request;
		return $this;
	}

	public function getRequest()
	{
		if (!$this->request) {
			throw new \ErrorException('$request variable not set');
		}
		return $this->request;
	}

	public function setCallable($callable)
	{
		$this->package = substr($callable[0], 0, strpos($callable[0], '\\'));
		$this->controller = $callable[0];
		$this->method = $callable[1];
		$this->callable = $callable;
		return $this;
	}

	public function getCallable()
	{
		return $this->callable;
	}

	public function getPackage()
	{
		return $this->package;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getRequestedPath()
	{
		return str_replace($this->getRequest()->getScriptName(), '', $this->getRequest()->server->get('PHP_SELF'));
	}

	public function search($requestedPath = null)
	{
		if (null === $requestedPath) {
			$requestedPath = $this->getRequestedPath();
		}

		$requestedPathArr = $this->getRequestedPathArr($requestedPath);

		if (count($requestedPathArr) === 0) {
			// search for [plugin] - [controller] - [method]
			$callable = $this->parseAsMissingAll($requestedPathArr);
			if ($this->isValidControllerCallable($callable)) {
				return $this->setCallable($callable);
			}

			// no need to further investigate empty request
			return;
		}

		// search for plugin - [controller] - [method]
		$callable = $this->parseAsMissingControllerAndMathodPath($requestedPathArr);
		if ($this->isValidControllerCallable($callable)) {
			return $this->setCallable($callable);
		}

		// search for plugin - controller - method
		$callable = $this->parseAsFullPath($requestedPathArr);
		if ($this->isValidControllerCallable($callable)) {
			return $this->setCallable($callable);
		}

		// search for plugin - controller - [method]
		$callable = $this->parseAsMissingMethodPath($requestedPathArr);
		if ($this->isValidControllerCallable($callable)) {
			return $this->setCallable($callable);
		}
	}

	protected function getRequestedPathArr($requestedPath)
	{
		if (!is_string($requestedPath)) {
			throw new \ErrorException('$requestedPath variable must be string, got: ' . gettype($requestedPath));
		}

		if (!preg_match("/^[a-z0-9\-\/]+$/i", $requestedPath)) {
			throw new \ErrorException('$requestedPath variable contains invalid characters: ' . $requestedPath);
		}

		// trim requested path
		$requestedPath = trim($requestedPath, '/');

		// eliminate duplications for slashes
		$requestedPath = preg_replace('/\/+/', '/', $requestedPath);

		// eliminate duplications for dahes
		$requestedPath = preg_replace('/\-+/', '-', $requestedPath);

		// form requested path arr
		$requestedPathArr = $requestedPath ? explode('/', $requestedPath) : array();

		// form classnames
		return array_map(function($item){

			// trim dashes
			$item = trim($item, '-');

			// replace dashes with whitespaces
			$item = str_replace('-', ' ', $item);

			// form classname
			$item = ucwords($item);

			// replace whitespaces with emptiness
			$item = str_replace(' ', '', $item);

			return $item;
		}, $requestedPathArr);
	}

	protected function parseAsFullPath(array $pathArr)
	{
		$plugin = array_shift($pathArr) . '\\Controller';
		$method = array_pop($pathArr);
		$controller = array_pop($pathArr). 'Controller';
		$path = implode('\\', $pathArr);
		return array(
			implode('\\', array_filter(array($plugin, $path, $controller))),
			lcfirst($method) . 'Action'
		);
	}

	protected function parseAsMissingMethodPath(array $pathArr)
	{
		$defaults = Container::getInstance()->get('config')->get('route');

		$plugin = array_shift($pathArr) . '\\Controller';
		$controller = array_pop($pathArr). 'Controller';
		$path = implode('\\', $pathArr);
		return array(
			implode('\\', array_filter(array($plugin, $path, $controller))),
			$defaults['default_method']
		);
	}

	protected function parseAsMissingControllerAndMathodPath(array $pathArr)
	{
		$defaults = Container::getInstance()->get('config')->get('route');

		$plugin = array_shift($pathArr) . '\\Controller';
		$controller = $defaults['default_controller'];
		$path = implode('\\', $pathArr);
		return array(
			implode('\\', array_filter(array($plugin, $path, $controller))),
			$defaults['default_method']
		);
	}

	protected function parseAsMissingAll(array $pathArr)
	{
		$defaults = Container::getInstance()->get('config')->get('route');

		return array(
			$defaults['default_package'] . '\\Controller\\' . $defaults['default_controller'],
			$defaults['default_method']
		);
	}

	protected function isValidControllerCallable($path)
	{
		$path[0] = 'PureGlassAnalytics\\Package\\' . $path[0];
		if (is_callable($path)) {
			return true;
		}
		return false;
	}
}
