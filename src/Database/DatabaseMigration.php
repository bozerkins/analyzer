<?php

namespace PureGlassAnalytics\Database;

use PureGlassAnalytics\Common\Debug;
use PureGlassAnalytics\Container\Container;

class DatabaseMigration
{
	protected function getDatabase()
	{
		return Container::getInstance()->get('database');
	}

	public function execute(array $sqls)
	{
		$output = array();
		$sequence = array_reverse($sqls);
		$versions = $this->getEligibleVersions(array_keys($sequence));

		foreach($versions as $version) {
			$output[] = 'Executing version: ' . $version;
			try {
				foreach($sequence[$version] as $sql) {
					$output[] = 'Executing: ' . $sql;
					$result = $this->getDatabase()->exec($sql);
					$output[] = 'OK. Affected rows: ' . $result;
				}
				$this->setVersionSuccessfull($version);
			} catch (\Exception $ex) {
				$output[] = 'ERROR. Execution interrupted with message: ' . $ex->getMessage();
				break;
			}
		}
		return $output;
	}

	public function getEligibleVersions(array $versions)
	{
		if (!$this->isTableInitialized()) {
			return $versions;
		}
		return $this->getMissingVersions($versions);
	}

	public function isTableInitialized()
	{
		try {
			$result = $this->getDatabase()->query("SELECT 1 FROM `migration` LIMIT 1");
		} catch (\Exception $e) {
			// We got an exception == table not found
			return FALSE;
		}

		// Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
		return $result !== FALSE;
	}

	public function getMissingVersions($versions)
	{
		$versionsSql = implode('\',\'', $versions);
		$sql = "SELECT version FROM `migration` WHERE version NOT IN ('{$versionsSql}')";

		$missingVersions = $this->getDatabase()->query($sql)->fetchAll();
		return array_map(function($item){
			return $item['version'];
		}, $missingVersions);
	}

	public function setVersionSuccessfull($version)
	{
		return $this->getDatabase()->prepare("INSERT INTO `migration` VALUES (?)")->execute(array($version));
	}

}
