<?php
/**
* Eigene Sessionverwaltung
*
* Das Prinzip:
* Bei jedem Start wird eine Session gesetzt mit einem Key. Dieser Key kann dann zusammen mit Informationen in die Tabelle "{praefix}session" geschrieben werden.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Session {
	/**
	* Generiert einen zufälligen Wert
	* @return string Sessionkey
	*/
	function generate()
	{
		$key = "";
		$id = time()*rand(0,49865148646348);
		for ($i=0; $i < strlen($id)/2; $i++) {
			$keystring = substr($id, $i, 2);
			$keystring = chr($keystring);
			$keystring = md5($keystring);
			$key .= substr($keystring, 0, 3);
		}
		return $key;
	}

	/**
	* Setzt bei jedem Seitenaufruf eine User-Session
	* @uses Session::generate()
	*/
	function set()
	{
		if(!isset($_SESSION["sessionkey"]))
		{
			$_SESSION["sessionkey"] = $this->generate();
		}
	}

	/**
	* Lies den Userkey aus
	* @return string Userkey aus Session
	*/
	static function read()
	{
		return $_SESSION["sessionkey"];
	}

	/**
	* Erstellt eine neue Session
	* @param string $name Name der Session
	* @param string $value Inhalt, der in der Session gespeichert werden soll
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::read()
	*/
	static function creat($name, $value)
	{
		$name = Security::injection($name);
		$value = Security::injection($value);

		$mysql = Mysql::command("INSERT INTO {praefix}session (`key`, name, value) VALUES ('".Session::read()."', '$name', '$value')");
		if($mysql) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Auslesen einer Session
	* @param string $name Name der Session, dessen Inhalt zurückgegeben werden soll
	* @return string|false Wert, der in der Session gespeichert ist. Im Fehlerfall wird false zurückgegeben.
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::read()
	*/
	static function get($name)
	{
		$name = Security::injection($name);

		$sql = Mysql::fetch_object("SELECT * FROM {praefix}session WHERE `key` = '".Session::read()."' AND name = '$name'");
		if($sql) {
			return $sql->value;
		}
		else {
			return false;
		}
	}

	/**
	* Ändern einer Session
	* @param string $name Name der Session
	* @param string $value Der neue Inhalt, der in der Session gespeichert werden soll
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::read()
	*/
	static function update($name, $value)
	{
		$name = Security::injection($name);
		$value = Security::injection($value);

		return Mysql::command("UPDATE {praefix}session SET value='$value' WHERE `key` = '".Session::read()."' AND name = '$name'");
	}

	/**
	* Löschen einer Session
	* @param string $name Der Name, der zu löschenden Session
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::read()
	*/
	static function destroy($name)
	{
		$name = Security::injection($name);

		return Mysql::command("DELETE FROM {praefix}session WHERE `key` = '".Session::read()."' AND name = '$name'");
	}


	/**
	* Prüfen, ob eine bestimmte Session vorhanden ist
	* @param string $name Name der Session, die überprüft werden soll
	* @return boolean true|false Gibt true zurück, wenn die Session vorhanden ist, false wenn nicht.
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::read()
	*/
	static function checkValue($name)
	{
		$name = Security::injection($name); //Absichern
		
		return Mysql::count("SELECT COUNT(id) FROM {praefix}session WHERE `key` = '".Session::read()."' AND name = '$name'");
	}
}
?>