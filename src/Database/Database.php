<?php

namespace PureGlassAnalytics\Database;

use PureGlassAnalytics\Common\Debug;

class Database
{
	protected $provider;

	public function setProvider(DatabaseProvider $provider)
	{
		$this->provider = $provider;
		return $this;
	}

	public function getProvider()
	{
		return $this->provider;
	}
}
