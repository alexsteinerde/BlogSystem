<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
if(Session::get("login") == 0) {
	exit();
}
$type = $_POST["type"];
//Template laden
$template = new template;
$template->load("admin_extensions_ind");

if($type == "Plugins") {
	$abfrage = Mysql::command("SELECT * FROM {praefix}extensions WHERE type='plugin'");
	while ($ext = mysql_fetch_object($abfrage)) {
		$template = new template;
		$template->load("admin_extensions_ind");
		$template->assignVar("EXT_NAME", $ext->name);
		$template->assignVar("EXT_DESC", $ext->beschreibung);
		$template->assignVar("EXT_VERSION", $ext->version);
		$template->assignVar("EXT_DOC", $ext->docuUrl);
		$template->assignVar("EXT_PIC", Url::rewrite("system/images/plugin.png"));
		if($ext->status == false) {
			$template->assignVar("USES", "<span onclick=\"pluginOn('$ext->link')\" class=\"aPointer\">Plugin aktivieren</span> | <span onclick=\"extDel('$ext->link')\" class=\"aPointer\">löschen</a>");
		}
		else {
			$template->assignVar("USES", "<span onclick=\"pluginOff('$ext->link')\" class=\"aPointer\">Plugin deaktivieren</span>");
		}
		$template->output();
	}

	if(mysql_num_rows($abfrage)	== 0) {
		echo "<i>Es sind keine Plugins installiert.</i>";
	}
}
elseif($type == "Skins") {
	$abfrage = Mysql::command("SELECT * FROM {praefix}extensions WHERE type='skin'");
	while ($ext = mysql_fetch_object($abfrage)) {
		$template = new template;
		$template->load("admin_extensions_ind");
		$template->assignVar("EXT_NAME", $ext->name);
		$template->assignVar("EXT_DESC", $ext->beschreibung);
		$template->assignVar("EXT_VERSION", $ext->version);
		$template->assignVar("EXT_DOC", $ext->docuUrl);
		$template->assignVar("EXT_PIC", Url::rewrite("system/skins/$ext->link/thumb.png"));
		if($ext->status == false) {
			$template->assignVar("USES", "<span onclick=\"updateSkin('$ext->link')\" class=\"aPointer\">Skin verwenden</span> | <span onclick=\"skinDel('$ext->link')\" class=\"aPointer\">löschen</a>");
		}
		else {
			$template->assignVar("USES", "");
		}
		$template->output();
	}
	if(mysql_num_rows($abfrage)	== 0) {
		echo "<i>Es sind keine Skins installiert.</i>";
	}
}
elseif($type == "Klassen") {
	$abfrage = Mysql::command("SELECT * FROM {praefix}extensions WHERE type='class'");
	while ($ext = mysql_fetch_object($abfrage)) {
		$template = new template;
		$template->load("admin_extensions_ind");
		$template->assignVar("EXT_NAME", $ext->name);
		$template->assignVar("EXT_DESC", $ext->beschreibung);
		$template->assignVar("EXT_VERSION", $ext->version);
		$template->assignVar("EXT_DOC", $ext->docuUrl);
		$template->assignVar("EXT_PIC", Url::rewrite("system/images/class.png"));
		$template->assignVar("USES", "<span onclick=\"extDel('$ext->link')\" class=\"aPointer\">löschen</a>");
		$template->output();
	}

	if(mysql_num_rows($abfrage)	== 0) {
		echo "<i>Es sind keine Klassen installiert.</i>";
	}
}
elseif($type == "Sidebar") {
	$abfrage = Mysql::command("SELECT * FROM {praefix}extensions WHERE type='sidebar'");
	while ($ext = mysql_fetch_object($abfrage)) {
		$template = new template;
		$template->load("admin_extensions_ind");
		$template->assignVar("EXT_NAME", $ext->name);
		$template->assignVar("EXT_DESC", $ext->beschreibung);
		$template->assignVar("EXT_VERSION", $ext->version);
		$template->assignVar("EXT_DOC", $ext->docuUrl);
		$template->assignVar("EXT_PIC", Url::rewrite("system/images/sidebar.png"));
			if($ext->status == false) {
			$template->assignVar("USES", "<span onclick=\"pluginOn('$ext->link')\" class=\"aPointer\">Element aktivieren</span> | <span onclick=\"extDel('$ext->link')\" class=\"aPointer\">löschen</a>");
		}
		else {
			$template->assignVar("USES", "<span onclick=\"pluginOff('$ext->link')\" class=\"aPointer\">Element deaktivieren</span>");
		}
		$template->output();
	}

	if(mysql_num_rows($abfrage)	== 0) {
		echo "<i>Es sind keine Sidebar Elemente installiert.</i>";
	}
}
?>