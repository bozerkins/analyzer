<?php

namespace PureGlassAnalytics\Database;

use PureGlassAnalytics\Common\Debug;

class DatabaseConnection
{
	protected $resource;
	protected $charset;
	protected $database;
	protected $host;
	protected $user;
	protected $password;

	public function setResource($resource)
	{
		$this->resource = $resource;
		return $this;
	}

	public function getResource()
	{
		return $this->resource;
	}

	public function setOptions(array $options)
	{
		$this->setChartset(array_key_exists('charset', $options) ? $options['charset'] : null);
		$this->setDatabase(array_key_exists('dbname', $options) ? $options['dbname'] : null);
		$this->setHost(array_key_exists('dbhost', $options) ? $options['dbhost'] : null);
		$this->setUser(array_key_exists('dbuser', $options) ? $options['dbuser'] : null);
		$this->setPassword(array_key_exists('dbpass', $options) ? $options['dbpass'] : null);
		return $this;
	}

	public function setChartset($charset)
	{
		$this->charset = $charset;
		return $this;
	}

	public function getCharset()
	{
		return $this->charset;
	}

	public function setDatabase($database)
	{
		$this->database = $database;
		return $this;
	}

	public function getDatabase()
	{
		return $this->database;
	}

	public function setHost($host)
	{
		$this->host = $host;
		return $this;
	}

	public function getHost()
	{
		return $this->host;
	}

	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}
}
