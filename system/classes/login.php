<?php
/**
* Login
*
* In dieser Klasse befinden sich alle Nötigen Funktionen für einen Login.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Login {
	/**
	* Prüft, ob Mail und Passwort übereinstimmen
	* @param string $mail E-Mail Adresse des Nutzers
	* @param string $pw Passwort des Nutzers(kein Hash)
	* @return boolean true|false Gibt true zurück, wenn der Login erfolgreich ist, false wenn nicht.
	* @uses Security::injection()
	* @uses Security::hash()
	* @uses Login::getM()
	*/
	static function log($mail, $pw)
	{
		$mail = Security::injection($mail);
		$pw = Security::injection(Security::hash($pw));
		$login = Login::getM($mail); //Auslesen

		if($login->pw == $pw) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Gibt Informationen anhand der E-Mail Adresse zurück.
	* @param string $mail E-Mail Adresse des Nutzers
	* @return array|boolean array|false Gibt Array mit Informationen zurück. Im Fehlerfall wird false zurückgegeben.
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function getM($mail)
	{
		$mail = Security::injection($mail);
		$return = Mysql::fetch_object("SELECT * FROM {praefix}login WHERE mail = '$mail' LIMIT 1");
		if($return) { //Prüfen ob die Abfrage erfolgreich war
			return $return; //Wenn ja, das Ergebniss zurückgeben
		}
		else {
			return false; //Im Fehlerfall false zurückgeben
		}
	}

	/**
	* Gibt Informationen anhand der User-ID zurück.
	* @param int $id ID des Nutzers
	* @return array|boolean array|false Gibt Array mit Informationen zurück. Im Fehlerfall wird false zurückgegeben.
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function getId($id)
	{
		$id = Security::injection($id);
		$return = Mysql::fetch_object("SELECT * FROM {praefix}login WHERE id = '$id' LIMIT 1");
		if($return) { //Prüfen ob die Abfrage erfolgreich war
			return $return; //Wenn ja, das Ergebniss zurückgeben
		}
		else {
			return false; //Im Fehlerfall false zurückgeben
		}
	}

	/**
	* Trägt neuen User in die Datenbank ein.
	* @param string $mail Angegebene E-Mail des Nutzers.
	* @param string $pw Passwort(kein Hash).
	* @param string $pw2 Wiederholtest Passwort(kein Hash).
	* @return boolean true|false 
	* @uses Security::injection()
	* @uses Security::hash()
	* @uses Mysql::command()
	*/
	static function register($mail, $pw, $pw2)
	{
		$mail = Security::injection($mail);
		$pw = Security::injection(Security::hash($pw));
		$pw2 = Security::injection(Security::hash($pw2));

		if($pw == $pw2 AND $pw != "d41d8cd98f00b204e9800998ecf8427e" AND isset($mail)) { //d41d8cd98f00b204e9800998ecf8427e ist der Wert für ein Leerzeichen
			$register = Mysql::command("INSERT INTO {praefix}login (mail, pw, first_time, right) VALUES ('$mail', '$pw', '".time()."', '1')"); //Eintragen
			if($register) {
			return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	static function logout() {
		Session::destroy("login");
		Session::update("pageright", "0");
	}
}
?>