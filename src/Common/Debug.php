<?php

namespace PureGlassAnalytics\Common;

class Debug
{
	public function out($info, $print = true)
	{
		$string = '<pre>' . print_r($info, true) . '</pre>';
		if ($print) {
			echo $string;
			return;
		}
		return $string;
	}

	public function message($message, $info, $print = true)
	{
		$string = $message . '<br><pre>' . print_r($info, true) . '</pre>';
		if ($print) {
			echo $string;
			return;
		}
		return $string;
	}

	public function outDie($info)
	{
		$string = '<pre>' . print_r($info, true) . '</pre>';
		echo $string;
		exit(0);
	}

	public function explain($info, $print = true)
	{
		ob_start();
		var_dump($info);
		$string = '<pre>' . ob_get_clean() . '</pre>';
		if ($print) {
			echo $string;
			return;
		}
		return $string;
	}

	public function explainDie($info, $print = true)
	{
		ob_start();
		var_dump($info);
		$string = '<pre>' . ob_get_clean() . '</pre>';
		echo $string;
		exit(0);
	}
}
