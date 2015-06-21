<?php

namespace PureGlassAnalytics\Route;

use PureGlassAnalytics\HttpFoundation\Request;

class RouteQuery
{
	protected $defaultPluginName = 'Home';
	protected $defaultControllerClass = 'indexController';
	protected $defaultControllerMethod = 'indexAction';

	protected $request;
	protected $relativePath;

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

	public function makeSearcher()
	{
		$path = trim(str_replace($this->request->getScriptName(), '', $this->request->server->get('PHP_SELF')), '/');

		$searcher =  new RouteSearcher();
		$searcher->setRelativePath($path);
		if (!$searcher->search()) {
			$searcher->setPluginName($this->defuultPluginName);
			$searcher->setControllerClass($this->defaultControllerClass);
			$searcher->setControllerMethod($this->defaultControllerMethod);
		}
		return $searcher;
	}
}
