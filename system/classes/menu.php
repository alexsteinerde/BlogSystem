<?php
/**
* Seitenmenü
*
* Kann Alle Menüpunkte ausgeben, neue erstellen und alte löschen.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Menu {
	/**
	* Ausgabe des Menüs für den entsprechenden Ordner
	* @param string $start HTML Tag, der vor jedem Link ausgegeben werden soll.
	* @param string $stop HTML Tag, der hinter jedem Link ausgegeben werden soll.
	* @return string Alle Links in einem "<a></a>" Tag, umschlossen von $start und $stop
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Pages::getBasename()
	*/
	static function get($start, $stop, $startactiv="")
	{
		//Ermitteln des Basename und abziehen des letzten "/"
		$page = Settings::pageData();
		$basename = Pages::getBasename($page);
		$basename = Security::injection($basename);
		$basenamepos = strrpos($basename, "/");
		$basename = substr($basename, 0, $basenamepos);

		//Ausgeben
		if(empty($startactiv)) {
			$startactiv = $start;
		}

		$ergebnis = Mysql::command("SELECT * FROM {praefix}menu WHERE dir = '$basename' ORDER BY list+0");
		while($menu = mysql_fetch_object($ergebnis))
		{
			if($menu->link == Settings::pageData()) {
				echo $startactiv;
			}
			else {
				echo $start;
			}
			echo "<a href=\"".Url::rewrite("page$menu->link")."\" >$menu->title</a>$stop";
		}
	}

	/**
	* Erstellen eines neuen Menüeintrags
	* @param string $title Titel eines neuen Menüeintrags(Standard ist "Default").
	* @param string $link Praefix, der in der URL hinter "page" steht. Muss der selbe Praefix sein, wie die Seite hat(Standard ist "/error").
	* @param integer $list Gibt die Reihenfolge an, wie die Einträge angezeigt werden sollen. 0 steht weiter vorne, wie 10("Standard ist 0).
	* @param integer $rechte (Standard ist 0)
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	* @todo Menürechte mit Tabelle
	* @todo Variable $rechte abschaffen
	* @todo $link Namensnennung
	*/
	static function creat($title="Default", $link="/error", $list=0, $dir)
	{
		$title = Security::injection($title);
		$link = Security::injection($link);
		$list = Security::injection($list);
		$dir = Security::injection($dir);

		if(Mysql::command("INSERT INTO {praefix}menu (title, link, list, dir) VALUES ('$title', '$link', '$list', '$dir')")) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Löscht Menüeintrage anhand ihres Praefixes
	* @param string $praefix Praefix der Seite.
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function delet($praefix)
	{
		$link = Security::injection($link);
		
		if(Mysql::command("DELETE FROM {praefix}menu WHERE link = '$praefix'")) {
			return true;
		}
		else {
			return false;
		}
	}
}
?>