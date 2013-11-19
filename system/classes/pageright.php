<?php
/**
* Regelt die Verteilung der Besucherrechte.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class PageRight {
	/**
	* Setzt beim ersten Aufruf der Seite eine Session
	* @uses Session::checkValue()
	* @uses PageRight::set()
	* @return boolean true|false
	*/
	function start()
	{
		if(!Session::checkValue("pageright")){
			return PageRight::set(0);
		}
	}

	/**
	* Setzen einer Pageright Session
	* @param integer $right Wert für die Session(0 ist normaler Besucher).
	* @return boolean true|false
	* @uses Session::creat()
	*/
	static function set($right)
	{
		return Session::creat("pageright", $right);
	}
}
?>