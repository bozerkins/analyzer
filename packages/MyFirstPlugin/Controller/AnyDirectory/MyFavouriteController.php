<?php

namespace PureGlassAnalytics\Package\MyFirstPlugin\Controller\AnyDirectory;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;

class MyFavouriteController extends Controller
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
