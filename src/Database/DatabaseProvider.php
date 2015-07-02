<?php

namespace PureGlassAnalytics\Database;

use PureGlassAnalytics\Common\Debug;

class DatabaseProvider
{
	protected $connections;

	public function addConnection(DatabaseConnection $connection)
	{
		if (is_null($key)) {
			$this->connections[] = $connection;
		} else {
			$this->connections[$key] = $conncetion;
		}
		return $this;
	}

	public function getConnection($key = null)
	{
		if (!$this->connections) {
			throw new \ErrorException('No database connections found');
		}
		if (!$key) {
			$connectionsAmount = count($this->connections);
			$key = $connectionsAmount > 1 ? rand(0, $connectionsAmount - 1) : 0;
		}
		return $this->connections[$key];
	}
}
