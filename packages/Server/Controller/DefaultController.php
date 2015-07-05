<?php

namespace PureGlassAnalytics\Package\Server\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\JsonResponse;
use PureGlassAnalytics\Container\Container;
use PureGlassAnalytics\Common\Debug;
use PureGlassAnalytics\WebApi\Server\Server;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$server = new Server();
		$server->setRequest(Container::getInstance()->get('request'));
		$server->configure(array(
			'action_key' => 'action',
			'params_key' => 'params'
		));
		$server->register('test', array($this, 'testServerMethod'));
		$response = $server->execute();

		return new JsonResponse($response);
	}

	public function testServerMethod($params)
	{
		return array(
			'the params are: ' => $params,
		);
	}
}
