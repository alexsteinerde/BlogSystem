<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
if(Session::get("login") == 0) {
	exit();
}
$type = $_GET["type"];
$ext = Security::injection($_POST["ext"]);

if($type == "updateSkin") {
	$now = Settings::get("skin");
	Extensions::updateStatus($now, 0);
	Extensions::updateStatus($ext, 1);
	Settings::update("skin", $ext);
}

if($type == "pluginOn") {
	Extensions::install($ext);
}

if($type == "pluginOff") {
	Extensions::uninstall($ext);
}

if($type == "skinDel") {
	if(Extensions::get($ext)->status == 0) {
		Upload::delDir("system/skins/".$ext);
		Extensions::delete($ext);
	}
}

if($type == "extDel") {
	if(Extensions::get($ext)->status == 0) {
		Upload::delDir("system/extensions/".$ext);
		Extensions::delete($ext);
	}
}
?>