<?php
/**
* Alex's Framework
*
* Unterdrückt die Fehlermeldungen, stellt eine Verbindung zur Datenbank her und ruft den Skin auf.
*
* @package  Systemfile
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
* @uses DEVELOPER
* @uses Mysql::connect()
* @uses Event::start()
* @uses Pages::siteCheck()
* @uses Settings
*/
require_once 'config.php';
if(!Event::start("start")) {
	echo "Es ist ein Fehler bei den Events aufgetreten.";
}
$permissions = Pages::siteCheck(@$_GET["page"]);
if(DEVELOPER) { echo $permissions; }
$settings = new Settings;
#############
/**
* Aufrufen des Skins.
*/
$basename = Pages::getBasename($_GET["page"]);
$basename = str_replace("/", "", $basename);
$count = Mysql::count("SELECT COUNT(id) FROM {praefix}settings WHERE var='skin_".$basename."'");

if($count == 1 AND $permissions != 403 AND $permissions != 404 AND $permissions != 406){
	require_once BASEPATH."/system/skins/".$settings->get("skin_".$basename)."/index.php";
}
else {
require_once BASEPATH."/system/skins/".$settings->get("skin")."/index.php";
}
?>