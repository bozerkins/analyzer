<?php

namespace PureGlassAnalytics\Router;

use PureGlassAnalytics\HttpFoundation\Request;

class RouterQuery
{
	protected $request;

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
}
