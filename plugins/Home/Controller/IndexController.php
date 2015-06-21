<?php

namespace PureGlassAnalytics\Plugins\Home\Controller;

use PureGlassAnalytics;

class IndexController extends Controller\Controller
{
	public function indexAction()
	{
		return HttpFoundation\Response(__METHOD__);
	}

	public function bulletProofAction()
	{
		return HttpFoundation\Response(__METHOD__);
	}
}
