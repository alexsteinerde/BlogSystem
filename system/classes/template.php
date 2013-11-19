<?php
/**
* Template
*
* Ersetzt etwas bestimmtes durch etwas anderes
*
* @package Framework
* @subpackage Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Template {
	/**
	* In dieser Variable wird der Dateiinhalt des Tempaltes gespeichert
	*/
	private $template;

	/**
	* Zu beginn muss das Template geladen und in die Varialbe "template" gespeichert werden.
	* @param string $file Templatename
	* @uses $template
	*/
	function load($file) {
		$this->template = file_get_contents("system/template/".$file.".html");
	}

	/**
	* Ermittelt die Urls
	* @uses $template
	*/
	function assignUrl() {
		$this->template = preg_replace("/{URL:(.*?)}/si", Url::rewrite("\\1"), $this->template);
	}

	/**
	* Ersetzt VAR:$loop durch $value
	* @param string $loop 
	* @param string $value
	* @uses $template
	*/
	function assignVar($loop, $value) {
		$this->template = str_ireplace("{VAR:".$loop."}", $value, $this->template);
	}

	/**
	* Ersetzt $loop durch $value
	* @param string $loop 
	* @param string $value
	* @uses $template
	*/
	function assign($loop, $value) {
		$this->template = str_ireplace("{".$loop."}", $value, $this->template);
	}

	/**
	* Diese Funktion muss vor assignLoopVar aufgerufen werden.
	* Es erkennt automatisch alle {LOOP} {/LOOP} und gibt diesen Inhalt zurück.
	* @param string $loop
	* @return string Inhalt des Loops
	* @uses $template
	*/
	function addLoopItem($loop) {
		preg_match("/{LOOP:$loop}(.*?){\/LOOP:$loop}/si", $this->template, $erg);
		return $erg[1];
	}

	/**
	* Ersetzt in einem Loop eine Variable
	* @param string $loopitem Die Rückgabe, die von addLoopItem kommt.
	* @param string $loop
	* @param string $value
	* @return Das ersetzte Template
	*/
	function assignLoopVar($loopitem ,$loop, $value) {
		return str_ireplace("{VAR:".$loop."}", $value, $loopitem);
	}

	/**
	* Wenn man mit Loops arbeitet, muss der in der Schleife als letztes zurückgegebene Inahlt an diese Funktion übergeben werden.
	* @param string $loop
	* @uses $template
	*/
	function getLoop($loop) {
		$this->template .= $loop;
	}

	/**
	* Um das Template auszugeben und um alle {Loop} {/Loop} wegzumachen.
	* @return string Gibt $template aus.
	* @uses $template
	*/
	function output() {
		$this->template = preg_replace("/{LOOP:(.*)}(.*){\/LOOP:(.*)}/si", "", $this->template);
		echo $this->template;
	}
}

?>