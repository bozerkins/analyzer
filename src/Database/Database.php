<?php

namespace PureGlassAnalytics\Database;

use PureGlassAnalytics\Common\Debug;

class Database
{
	protected $connection;

	public function setConnection($connection)
	{
		$this->connection = $connection;
		return $this;
	}

	public function getConnection()
	{
		return $this->connection;
	}
}
