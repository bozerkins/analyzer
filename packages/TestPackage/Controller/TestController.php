<?php

namespace PureGlassAnalytics\Package\TestPackage\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\Container\Container;
use PureGlassAnalytics\Common\Debug;

class TestController extends Controller
{
	public function indexAction()
	{
		$db = Container::getInstance()->get('database');
		$result = $db->query("SELECT login FROM agent__info LIMIT 10")->fetchAll();

		Debug::out($result);

		return new Response('Method: <b>' . __METHOD__ . '<b>');
	}
}
