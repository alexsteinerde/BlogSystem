<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
class modul_updater {
	public function display()
	{
		if(Settings::get("update") == 1) {
			$content = $this->updaterModul();
			$query = Mysql::command("SELECT * FROM {praefix}extensions");
			while ($ext = mysql_fetch_object($query)) {
				//$content .= $this->updaterModul($ext->link, $ext->name);
			}
		}

		if(@$content == "") {
			if(Settings::get("update") == 1) {
				$content = "Es wurden keine Updates gefunden!";
			}
			else {
				$content = "<i>Bitte aktivieren sie die Updatesuche in den Einstellungen.</i>";
			}
		}


		$template = new template;
		$template->load("modul");
		$template->assignVar("TITLE", "Updates");
		$template->assignVar("CSS_CLASS", "updater");
		$template->assignVar("CONTENT", $content."<p>Weitere Informationen findest du hier: <a href=\"http://blogsystem.alexsteiner.de/page/update-overview\" target=\"_blank\">Update &Uuml;bersicht</a></p>");
		$template->output();
	}

	public function updaterModul($type="system", $typename="System")
	{
		$update = new Updater($type);
		if(!$update) {
			HTML::redBox("Fehler. Bitte wende dich an mich.");
		}
		if(isset($_GET["systemdownload"]) AND $_GET["type"] == $type) {
			$update->downloadAll();
			HTML::greenBox("Erfolgreich heruntergeldaden");
		}

		if(isset($_GET["systeminstall"]) AND $_GET["type"] == $type) {
			$update->installAll();
			HTML::greenBox("Erfolgreich installiert");
		}

		$file = false;
		$files = Upload::checkDir("system/temp/updates");
		for ($i=0; $i < count($files); $i++) { 
			if(strpos($files[$i], $type."_") != false) {
				$file = true;
				break;
			}
		}
		if($file) {
			$content = "<h3>$typename</h3><b>Es sind Updates zum installieren verf&uuml;gbar.</b> <br />
			<div><a href=\"".Url::rewrite("page/admin/home?systeminstall&type=$type")."\">Updates installieren</a></div>";
		}
		else if($update->checkUpdate() != 0) {
			if($update->checkUpdate() > 1) {
				$be = "sind";
				$toupdate = "Updates";
			}
			else {
				$be = "ist";
				$toupdate = "Update";
			}
			$content = "<h3>$typename</h3><b>Es ".$be." ".$update->checkUpdate()." ".$toupdate." zum downloaden verf&uuml;gbar.</b> <br />
			<div><a href=\"".Url::rewrite("page/admin/home?systemdownload&type=$type")."\">Updates herunterladen</a></div>";
		}
		return @$content;
	}
}
?>