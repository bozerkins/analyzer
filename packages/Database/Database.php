<?php

namespace PureGlassAnalytics\Package\Database;

use PureGlassAnalytics\Database\DatabaseConnection;
use PureGlassAnalytics\Container\Container;

class Database extends \PureGlassAnalytics\Database\Database
{
	public function __construct()
	{
		$connection = new DatabaseConnection();
		$connection->setOptions(Container::getInstance()->get('config')->get('database'));

		$provider = new DatabaseProvider\DatabaseProviderPDO();
		$provider->addConnection($connection);

		$this->setProvider($provider);
	}

	public function query($sql)
	{
		return $this->getProvider()->getConnection()->getResource()->query($sql);
	}

	public function exec($sql)
	{
		return $this->getProvider()->getConnection()->getResource()->exec($sql);
	}

	public function prepare($sql)
	{
		return $this->getProvider()->getConnection()->getResource()->prepare($sql);
	}

}
