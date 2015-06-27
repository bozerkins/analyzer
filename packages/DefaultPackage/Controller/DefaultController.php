<?php

namespace PureGlassAnalytics\Package\DefaultPackage\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;

class DefaultController extends Controller
{
	public function indexAction()
	{
		return new Response('Method: <b>' . __METHOD__ . '<b>');
	}
}
