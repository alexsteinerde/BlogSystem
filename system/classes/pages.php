<?php
/**
* Verwaltet die Seitenausgabe usw.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Pages {
	/**
	* Gibt die Seiteninformationen zurück
	* @param string $page In $page muss der Praeifx 
	* @return array|false Gibt die Informationen in Form eines Arrays zurück. Im Fehlerfall wird false zurückgegeben.
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function get($page)
	{
		$page = Security::injection($page);
		return Mysql::fetch_object("SELECT * FROM {praefix}pages WHERE praefix = '$page'");
	}

	/**
	* Erstellt eine neue Seite
	* @param string $title Titel der Seite(Standard ist "Default")
	* @param string $praefix Praefix der Seite. Muss mit einem "/" beginnen(Standart ist "/error").
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function creat($title="Default",$class, $praefix="/error")
	{
		$title = Security::injection($title);
		$praefix = Security::injection($praefix);
		$class = Security::injection($class);

		return Mysql::command("INSERT INTO {praefix}pages (title, praefix, class) VALUES ('$title', '$praefix', '$class')");
	}

	/**
	* Löscht eine Seite
	* @param string $praefix Der Praefix der zu löschenden Seite.
	* @return boolean true|false
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function delet($praefix)
	{
		$praefix = Security::injection($praefix);

		return Mysql::command("DELETE FROM {praefix}pages WHERE praefix = '$praefix'");
	}

	/**
	* Gibt den Unterordner einer Seite zurück.
	* @param string $page Praefix der Seite
	* @return string Basname der Seite
	*/
	static function getBasename($page) {
		$lastpage = strrchr($page, "/");
		return str_replace($lastpage, "", $page)."/";
	}

	/**
	* Prüft, ob der jetzige User die passenden Rechte hat, um die Seite einzusehen.
	* @param string $page Praefix der Seite, deren Rechte geprüft werden sollen.
	* @return integer 200|403|404|406|416 Fehlercode. 200=OK, 403=Rechte, 404 Datei nicht gefunden, 406=Seite nicht in der Datenbank, 416=$page ist leer
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::get()
	*/
	static function siteCheck($page='')
	{
		$page = Security::injection($page); //Absichern
		$pageright = $page; //Clonnen des Wertes
		$basename = Pages::getBasename($page);
		if($page == "") { //Page leer
			return 416;
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}pages WHERE praefix = '$pageright'") == 0) { //Datei in der DB?
			return 406;
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}pageright WHERE page = '$basename' AND `right` LIKE '".Session::get("pageright")."'") != 0) { //Rechte auf ganzen Ordner übertragen
			return 200;
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}pageright WHERE page = '$basename' AND `right` LIKE 'G-%'") != 0){  //Prüfen, ob eine Gruppe als Recht angegeben ist
			$group = Mysql::fetch_object("SELECT * FROM {praefix}pageright WHERE page = '$basename' AND `right` LIKE 'G-%'");
			$right = explode("G-", $group->right);
			$right = $right[1];
			if(Mysql::count("SELECT COUNT(id) FROM {praefix}groupsfollower WHERE `group` = '$right' AND user = '".Session::get("login")."'") != 0){
				return 200;
			}
			else {
				return 403;
			}
		}

		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}pageright WHERE page = '$pageright' AND `right` LIKE 'G-%'") != 0){  //Prüfen, ob eine Gruppe als Recht angegeben ist
			$group = Mysql::fetch_object("SELECT * FROM {praefix}pageright WHERE page = '$pageright' AND `right` LIKE 'G-%'");
			$right = explode("G-", $group->right);
			$right = $right[1];
			if(Mysql::count("SELECT COUNT(id) FROM {praefix}groupsfollower WHERE `group` = '$right' AND user = '".Session::get("login")."'") != 0){
				return 200;
			}
			else {
				return 403;
			}
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}pageright WHERE page = '$pageright' AND `right` = '".Session::get("pageright")."'") == 0){ //Genügedn Rechte in der pageright Tabelle?
			return 403;
		}
		else { //Alles OK!
			return 200;
		}
	}
}
?>