<?php

namespace PureGlassAnalytics\Route;

use Symfony\Component\HttpFoundation\Response;

class Route
{
	public function resolve(RouteQuery $query)
	{
		// run query search
		$query->search();

		// check if controller found
		if (!$query->getCallable()) {
			throw new \ErrorException('Path not found: ' . $query->getRequestedPath());
		}

		// invoke controller
		$response = $this->invoke($query->getCallable());

		// validate response
		if (!$response instanceof Response) {
			throw new \ErrorException('$response variable must be and instance of Response class. Controller returned: ' . gettype($response));
		}

		// return response
		return $response;
	}

	protected function invoke($callable)
	{
		$callable[0] = 'PureGlassAnalytics\\Package\\' . $callable[0];
		$controller = new $callable[0]();
		return $controller->{$callable[1]}();
	}
}
