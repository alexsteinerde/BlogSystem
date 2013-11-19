<?php
/**
* URL verändern
*
* Setzt vor jeder Übergebenen URL den HTTP Host. Funktioiert nur bei HTML usw. Dateien.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Url {
	/**
	* URL mit Host verbinden
	* @param string $url Pfand innerhalb des Systemes
	* @return string Absolute Pfad Angabe
	* @uses Settings::host()
	*/
	static function rewrite($url)
	{
		$host = Settings::host();
		return "$host$url";
	}
}
?>