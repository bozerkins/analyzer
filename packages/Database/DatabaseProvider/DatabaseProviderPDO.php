<?php

namespace PureGlassAnalytics\Package\Database\DatabaseProvider;

use PureGlassAnalytics\Database\DatabaseProvider;
use PureGlassAnalytics\Database\DatabaseConnection;

class DatabaseProviderPDO extends DatabaseProvider
{
	public function addConnection(DatabaseConnection $connection)
	{
		$this->initialize($connection);

		return parent::addConnection($connection);
	}

	public function initialize(DatabaseConnection $connection)
	{
		$resource = new \PDO(
			"mysql:host={$connection->getHost()};dbname={$connection->getDatabase()};charset={$connection->getCharset()}",
			$connection->getUser(),
			$connection->getPassword()
		);

		$resource->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$resource->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

		$connection->setResource($resource);
		return $this;
	}
}
