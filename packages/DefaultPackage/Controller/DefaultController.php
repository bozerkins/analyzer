<?php

namespace PureGlassAnalytics\Package\DefaultPackage\Controller;

use PureGlassAnalytics\Controller\Controller;
use PureGlassAnalytics\HttpFoundation\Response;
use PureGlassAnalytics\HttpFoundation\TemplateResponse;
use PureGlassAnalytics\Container\Container;
use PureGlassAnalytics\Common\Debug;

class DefaultController extends Controller
{
	public function indexAction()
	{
		return new TemplateResponse('DefaultPackage::templates::default_template.php', array(
			'name' => Container::getInstance()->get('request')->get('name', 'UNKNOWN')
		));
	}
}
