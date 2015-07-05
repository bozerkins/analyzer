<?php

require_once __DIR__ . '/../../bootstrap.php';

$migration = $kernel->getContainer()->get('migration');

$sqls = array();

$sqls['0.0.3'] = array(
	"INSERT INTO `config` VALUES('a12', 'b'), ('b12', 'c'), ('c12', 'd');",
);

$sqls['0.0.2'] = array(
	"CREATE TABLE IF NOT EXISTS `config` (
	  `key` varchar(50) NOT NULL,
	  `value` varchar(100) DEFAULT NULL,
	  PRIMARY KEY (`key`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
	"INSERT INTO `config` VALUES('a', 'b'), ('b', 'c'), ('c', 'd');",
	"DELETE FROM `config` WHERE `key` = 'b';",
);

$sqls['0.0.1'] = array(
	"CREATE TABLE IF NOT EXISTS `migration` (
	`version` varchar(10) NOT NULL,
	PRIMARY KEY (`version`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;",
);

$results = $migration->execute($sqls);
echo implode(PHP_EOL, $results);
