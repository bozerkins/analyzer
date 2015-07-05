<?php

namespace PureGlassAnalytics\WebApi\Server;

use PureGlassAnalytics\HttpFoundation\Request;

class Server
{
	protected $request;
	protected $methods = array();
	protected $conf = array();

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

	public function configure(array $conf)
	{
		$this->conf = $conf;
		return $this;
	}

	public function register($action, $callback)
	{
		if (!is_callable($callback)) {
			throw new \ErrorException('No callable callback passed');
		}
		$this->methods[$action] = $callback;
		return $this;
	}

	public function execute()
	{
		$callable = $this->getCallable($this->getAction());
		return call_user_func_array($callable, array($this->getParams()));
	}

	protected function getAction()
	{
		$actionKey = $this->getActionKey();
		$action = $this->getRequest()->get($actionKey);
		if (!$action) {
			throw new \ErrorException('No action received');
		}
		return $action;
	}

	protected function getActionKey()
	{
		$key = $this->conf['action_key'];
		if (!$key) {
			throw new \ErrorException('Invalid action key passed');
		}
		return $key;
	}

	protected function getParams()
	{
		$paramsKey = $this->getParamsKey();
		$params = $this->getRequest()->get($paramsKey);
		if (is_null($params)) {
			throw new \ErrorException('No params received');
		}
		return $params;
	}

	protected function getParamsKey()
	{
		$key = $this->conf['params_key'];
		if (!$key) {
			throw new \ErrorException('Invalid params key passed');
		}
		return $key;
	}

	protected function getCallable($action)
	{
		$callable = $this->methods[$action];
		if (!$callable) {
			throw new \ErrorException('No callable found');
		}
		return $callable;
	}
}
