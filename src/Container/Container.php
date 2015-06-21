<?php

namespace PureGlassAnalytics\Container;

class Container
{
	/**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

	protected $services = array();
	protected $registry = array();

	public function get($key, $invoke = true, $silent = false)
	{
		if (array_key_exists($key, $this->services)) {
			return $this->services[$key];
		}
		if ($invoke) {
			return $this->invokeRegistryItem($key)->get($key);
		}
		if (!$silent) {
			throw new \ErrorException('Calling to undefined service: ' . $key);
		}
		return null;
	}

	public function set($key, $object)
	{
		if ($this->get($key, false, true)) {
			throw new \ErrorException('Trying to overwrite existing service: ' . $key);
		}
		$this->services[$key] = $object;
		return $this;
	}

	public function addRegistry(array $registry)
	{
		foreach($registry as $key => $class) {
			$this->addRegistryItem($key, $class);
		}
		return $this;
	}

	public function getRegistryItem($key, $silent = false)
	{
		if (array_key_exists($key, $this->registry)) {
			return $this->registry[$key];
		}
		if (!$silent) {
			throw new \ErrorException('Calling to undefined service: ' . $key);
		}
		return null;
	}

	public function addRegistryItem($key, $class)
	{
		if ($this->getRegistryItem($key, true)) {
			throw new \ErrorException('Trying to overwrite existing registry item: ' . $key);
		}
		$this->registry[$key] = $class;
		return $this;
	}

	public function invokeRegistryItem($key)
	{
		$class = $this->getRegistryItem($key);
		return $this->set($key, new $class());
	}
}
