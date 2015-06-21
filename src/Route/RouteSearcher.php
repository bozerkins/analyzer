<?php

namespace PureGlassAnalytics\Route;

use PureGlassAnalytics\HttpFoundation\Request;

class RouteSearcher
{
	protected $relativePath;
	protected $relativePathItems;

	protected $pluginName;
	protected $controllerClass;
	protected $controllerMethod;

	public function search()
	{
		$items = $this->getRelativePathItems();
		if (!$items) {
			return false;
		}

		$this->setPluginName($this->getUriItemsToClass(array_slice($items, 0, 1)));

		$this->setControllerClass($this->getUriItemsToClass(array_slice($items, 1, count($items) - 2)));

		$this->setControllerMethod(lcfirst($this->getUriItemsToClass(array_slice($items, count($items) - 1, 1))) . 'Action');

		return true;
	}

	public function setRelativePath($relativePath)
	{
		if (!$this->isRelativePathValid($relativePath)) {
			throw new \ErrorException('Invalid relative path specified: ' . $relativePath);
		}
 		$this->relativePath = $relativePath;
		$this->relativePathItems = explode('/', $this->relativePath);
		if (!$this->isRelativePathItemsValid($this->relativePathItems)) {
				throw new \ErrorException('Invalid relative path items specified: ' . $relativePath);
		}

		return $this;
	}

	public function getRelativePath()
	{
		return $this->relativePath;
	}

	public function getRelativePathItems()
	{
		return $this->relativePathItems;
	}

	public function isRelativePathValid($relativePath)
	{
		return preg_match('/^[a-z\-\/]+$/', $relativePath);
	}

	public function isRelativePathItemsValid(array $relativePathItems)
	{
		return count($relativePathItems) > 2 || count($relativePathItems) === 0;
	}

	public function setPluginName($pluginName)
	{
		$this->pluginName = $pluginName;
		return $this;
	}

	public function getPluginName()
	{
		return $this->pluginName;
	}

	public function setControllerClass($controllerClass)
	{
		$this->controllerClass = $controllerClass;
		return $this;
	}

	public function getControllerClass()
	{
		return $this->controllerClass;
	}

	public function setControllerMethod($controllerMethod)
	{
		$this->controllerMethod = $controllerMethod;
		return $this;
	}
	public function getControllerMethod()
	{
		return $this->controllerMethod;
	}

	protected function getUriItemsToClass(array $uriItems)
	{
		return implode('\\', array_map(array($this, 'getUriToClass'), $uriItems));
	}

	protected function getUriToClass($uri)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $uri)));
	}
}
