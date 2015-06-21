<?php

namespace PureGlassAnalytics\Config;

class Config
{
	// variables
	protected $environment;

	// setters | getters

	public function setEnvironment($environment)
	{
		$this->environment = $environment;
		return $this;
	}

	public function getEnvironment()
	{
		return $this->environment;
	}

	// main methods
	public function get($file)
	{
		if (!preg_match('/^[a-zA-Z\_\/]+$/', $file)) {
			throw new \ErrorException('Invalid configuration file name received: ' . $file);
		}

		$path = __DIR__ . '/../../config/' . $this->getEnvironment() . '/' . $file . '.php';

		if (file_exists($path)) {
			return require $path;
		}

		throw new \ErrorException('Requesting not existing configuration file: ' . $file);
	}
}
