<?php
/**
* MySQL
*
* Enthält alle wichtigen Funktionen, die man beim Umgang mit MySQL braucht.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Mysql
{
	/**
	* Herstellen einer Verbindung zur Datenbank und auswählen einer Datenbank.
	* @return boolean true|false
	*/
	static function connect()
	{
		require BASEPATH."/system/config/dbsettings.php";

		$verbindung = mysql_connect($host, $user, $pw);
		$data = mysql_select_db($database);
		if($verbindung && $data) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Auslesen des Tabellenpraefixes
	* @return string Praefix, der vor jeder Tabelle steht.
	*/
	static function praefix()
	{
		require BASEPATH."/system/config/dbsettings.php";
		return $praefix;
	}

	/**
	* Führt ein mysql_query aus und setzt den Praefix ein.
	* @param string $command Gültiger SQL befehlt mit Praefixplatzhalter({praefix}).
	* @return array Gibt das zurück, was der mysql_query zurück gibt.
	* @uses Mysql::praefix()
	*/
	static function command($command)
	{
		$command = str_replace("{praefix}", Mysql::praefix(), $command);
		return mysql_query($command);
	}

	static function count($command)
	{
		$query = Mysql::command($command);
		$ret = mysql_fetch_row($query);
		return $ret[0];
	}

	static function fetch_object($command) {
		$query = Mysql::command($command);
		return mysql_fetch_object($query);
	}
}
?>