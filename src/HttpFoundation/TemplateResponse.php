<?php

namespace PureGlassAnalytics\HttpFoundation;

use PureGlassAnalytics\Common\Debug;

class TemplateResponse extends Response
{
	public function __construct($templatePath, $variables = array())
	{
		$pathArr = explode('::', $templatePath);
		$packageName = array_shift($pathArr);

		$path = $packageName . '/Resource/' . implode('/', $pathArr);
		var_export($variables);
		ob_start();
		require $path;
		return ob_get_clean();
	}
}
