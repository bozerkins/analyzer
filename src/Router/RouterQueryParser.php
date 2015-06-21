<?php

namespace PureGlassAnalytics\Router;

use PureGlassAnalytics\HttpFoundation\Request;

class RouterQueryParser
{
	protected $relativePath;
	protected $relativePathItems;

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

	public function getPluginName()
	{
		$items = $this->getRelativePathItems();
		return $this->getUriItemsToClass(array_slice($items, 0, 1));
	}

	public function getControllerClass()
	{
		$items = $this->getRelativePathItems();
		return $this->getUriItemsToClass(array_slice($items, 1, count($items) - 2));
	}

	public function getControllerMethod()
	{
		$items = $this->getRelativePathItems();
		return lcfirst($this->getUriItemsToClass(array_slice($items, count($items) - 1, 1))) . 'Action';
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
