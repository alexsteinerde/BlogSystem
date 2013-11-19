<?php
/**
* Events
*
* Alle in der Tabelle "{praefix}events" stehenden Klassen und Funktionen werden bei jedem Seitenaufruf aufgerufen.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Event {
	/**
	* Führt alle in der DB angegebenen Klassen/Funktionen aus.
	* @return boolean true|false
	* @uses Mysql::command()
	*/
	static function start($point)
	{
		$point = Security::injection($point);
		$false = true; //Variable auf True setzen, damit keine Notice kommt
		$ergebnisse = Mysql::command("SELECT * FROM {praefix}events WHERE `point`='$point'");
		while($event = mysql_fetch_object($ergebnisse)) {
			$class = new $event->class;
			$function = $event->function;
			$return = $class->$function(); //Ausführen der Funktion
			if($return === false) {
				$false = false;
			}
		}
		if(!$false) {
			return false;
		}
		else {
			return true;
		}
	}

	/**
	* Erstellt ein neues Event
	* @param string $class Klasse, die aufgerufen werden soll.
	* @param string $function Funktion, die in der Klasse aufgerufen werden soll(ohne Klammern).
	* @return boolean true|false
	* @uses Mysql::command()
	* @uses Security::injection()
	*/
	static function set($class, $function, $point)
	{
		$class = Security::injection($class);
		$function = Security::injection($function);
		$point = Security::injection($point);
		if(Mysql::command("INSERT INTO {praefix}events (class, function, `point`) VALUES ('$class', '$function', '$point')")) {
			return true;
		}
		else {
			return false;
		}
	}

	static function delete($class, $function, $point)
	{
		$class = Security::injection($class);
		$function = Security::injection($function);
		$point = Security::injection($point);
		return Mysql::command("DELETE FROM {praefix}events WHERE class='$class' AND function='$function' AND `point`='$point'");
	}
}
?>