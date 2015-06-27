<?php

namespace PureGlassAnalytics\Package\MyFirstPlugin\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;

class SimpleController extends Controller
{
	public function indexAction()
	{
		return new Response('Method: <b>' . __METHOD__ . '<b>');
	}

	public function fuckOffDudeAction()
	{
		return new Response('Method: <b>' . __METHOD__ . '<b>');
	}
}
