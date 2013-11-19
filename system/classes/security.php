<?php
/**
* Sicherheitsklasse
*
* Enthält einen Schutz vor MySQL Injection, Funktionen zum verschlüssln von Daten und eine Funktion, die einen Hash bildet.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Security {
	/**
	* Schützt die Datenbank von Manipulationen
	* @param string $var Alle in der Varibable enthaltenen SQL Befehle werden unschätzlich gemacht.
	* @return string Enthält die unschätlich gemachte Variable
	*/
	static function injection($var)
	{
		#$var = htmlentities($var);
		$var = mysql_real_escape_string($var);
		return $var;
	}

	/**
	* Generiert einen Key aus einem Publickey und einem Privatekey
	* @param string $publickey
	* @param string $privatekey
	* @return integer
	*/
	static function key($publickey, $privatkey)
	{
		$publickeynr = ""; //Key aus dem Publickey
		$privatekeynr = ""; //Key aus dem Privatekey
		for ($i=0; $i < strlen($publickey); $i++) { 
		$publickeynr .= ord(substr($publickey, $i, 1));
		}

		for ($i=0; $i < strlen($privatkey); $i++) { 
			$privatekeynr .= ord(substr($privatkey, $i, 1));
		}

		return crc32($privatekeynr*$publickeynr)+crc32($privatekeynr)-crc32($publickeynr);
	}

	/**
	* Verschlüsselt einen String
	* @param string $string Zu verschlüsselnde Zeichenreihe
	* @param string $publickey Öffentlicher Schlüssel
	* @param string $privatekey Privater Schlüssel
	* @return string Verschlüsselte Zeichenreihe
	* @uses Security::key()
	*/
	static function encode($string, $publickey, $privatkey)
	{
		$key = Security::key($publickey, $privatkey); //Schlüssel generieren
		$lg = strlen($string); //Länge des Strings ermitteln
		$crypt = ""; //Variable $crypt setzen. In dieser wird später der verschlüsselte String gespeichert.
		for ($i=0; $i < $lg; $i++) {
			$char = substr($string, $i, 1); //Immer ein Zeichen auswählen
			$code = ord($char); //Zeichennummer ermitteln
			$newcode = $code + $key; //Zeichennummer mit dem Key addieren
			$newchar = chr($newcode); //Aus Zeichennummer wieder ein Zeichen machen
			$crypt .= $newchar; //Zeichen an die Variable hängen
		}

		return base64_encode($crypt);
	}

	/**
	* Entschlüsselt einen String
	* @param string $string Zu endschlüsselnde Zeichenreihe
	* @param string $publickey Öffentlicher Schlüssel
	* @param string $privatekey Privater Schlüssel
	* @return string Endschlüsselte Zeichenreihe
	* @uses Security::key()
	*/	
	static function decode($string, $publickey, $privatkey)
	{
		$key = Security::key($publickey, $privatkey); //Schlüssel generieren
		$string = base64_decode($string);
		$lg = strlen($string); // Länge des Strings ermitteln
		$crypt = ""; //Variable $crypt setzen. In dieser wird später der endschlüsselte String gespeichert.
		for ($i=0; $i < $lg; $i++) { 
			$char = substr($string, $i, 1); //Immer ein Zeichen auswählen
			$code = ord($char); //Zeichennummer ermitteln
			$newcode = $code - $key; //Zeichennummer von dem Key subtrahieren
			$newchar = chr($newcode); //Aus Zeichennummer wieder ein Zeichen machen
			$crypt .= $newchar; //Zeichen an die Variable hängen
		}

		return $crypt;
	}

	/**
	* Bildet einen Hashwert
	* @param string $string Aus diesem String wird ein Hashwert gebildet.
	* @return string Hashwert
	*/
	static function hash($string)
	{
		$string = base64_encode($string);
		$string = md5($string);
		$string = sha1($string);
		$string = md5($string);
		$string = base64_encode($string);
		return $string;
	}
}
?>