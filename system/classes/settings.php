<?php
/**
* Systemsettings
*
* In der Tabelle "{praefix}settings" können Systemeinstellunegn gespeichert werden.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Settings {
	/**
	* Auslesen einer bestimmten Einstellung
	* @param string $settings
	* @return string|false Gibt den Wert der Einstellung zurück
	* @uses Security::injection()
	* @uses  Mysql::command()
	*/
	static function get($settings)
	{
		$settings = Security::injection($settings); //Absichern

		return Mysql::fetch_object("SELECT * FROM {praefix}settings WHERE var = '$settings'")->value;
	}

	/**
	* Aktuelle Seitenangabe ermitteln.
	* @return string Neue Seitenangabe
	* @uses Pages::siteCheck()
	*/
	static function pageData()
	{
		$page = @$_GET["page"];
		$permissions = Pages::siteCheck($page);
		if($permissions == 200) {
			return $page;
		}
		elseif($permissions == 403 OR $permissions == 404 OR $permissions == 406) {
			return "/".Settings::errorPage($page);
		}
		elseif($permissions == 416) {
			return "/home";
		}
	}

	/**
	* Http-Host aus Datenbank auslesen
	* @return string Host
	* @uses Settings::get()
	*/
	static function host()
	{
		return Settings::get("host");
	}

	/**
	* Einstellung erstellen
	* @param string $var Name der Einstellung
	* @param string $context Wert, der gespeichert werden soll
	* @return boolean true|false 
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function creat($var, $context)
	{
		$var = Security::injection($var);
		$value = Security::injection($context);

		return Mysql::command("INSERT INTO {praefix}settings (var, value) VALUES ('$var', '$value')");
	}

	static function update($var, $context) {
		$var = Security::injection($var);

		return Mysql::command("UPDATE {praefix}settings SET value='$context' WHERE var = '$var'");
	}

	/**
	* Einstellungen löschen
	* @param string $var Name der Einstellung
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function delet($var)
	{
		$var = Security::injection($var);
		
		return Mysql::command("DELETE FROM {praefix}settings WHERE var = '$var'");
	}

	static function errorPage($page)
	{
		$basename = Pages::getBasename($page);
		$basename = str_replace("/", "", $basename);
		$count = Mysql::count("SELECT COUNT(id) FROM {praefix}settings WHERE var='error_".$basename."'");
		if($count == 1){
			return Settings::get("error_".$basename);
		}
		else {
			return Settings::get("error");
		}
	}
}
?>