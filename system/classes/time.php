<?php
/**
* Short
*
* Long
*
* @package Framework
* @subpackage Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Time {
	static function timePast($time1) {
		$timestamp = time() - $time1;

		if($timestamp < 60)
		{
			if($timestamp == 1)
			{
				$sekunden = "Sekunde";
			}
			else
			{
				$sekunden = "Sekunden";
			}
			return "vor $timestamp $sekunden";
		}
		else if($timestamp < 3600)
		{
			$timestamp = round($timestamp / 60);
			if($timestamp == 1)
			{
				$sekunden = "Minute";
			}
			else
			{
				$sekunden = "Minuten";
			}
			return "vor $timestamp $sekunden";
		}
		else if($timestamp < 86400)
		{
			$timestamp = round($timestamp / 60);
			$timestamp = round($timestamp / 60);
			if($timestamp == 1)
			{
				$sekunden = "Stunde";
			}
			else
			{
				$sekunden = "Stunden";
			}
			return "vor $timestamp $sekunden";
		}
		else 
		{
			$timestamp = date("d.m.Y", $time1);
			return "$timestamp";
		}
	}
}
?>