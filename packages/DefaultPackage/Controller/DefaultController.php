<?php

namespace PureGlassAnalytics\Package\DefaultPackage\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\Container\Container;
use PureGlassAnalytics\Common\Debug;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$db = Container::getInstance()->get('database');
		return new Response('Method: <b>' . __METHOD__ . '<b>');
	}
}
