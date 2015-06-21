<?php

namespace PureGlassAnalytics\Router;

use PureGlassAnalytics\HttpFoundation\Request;

class RouterQuery
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

	public function makeParser()
	{
		$path = trim(str_replace($this->request->getScriptName(), '', $this->request->server->get('PHP_SELF')), '/');

		$parser =  new RouterQueryParser();
		return $parser->setRelativePath($path);
	}
}
