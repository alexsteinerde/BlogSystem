<?php
class Page_admin_settings {
	function display() {
		if(isset($_GET["save"]))
		{
			$ergebnis = Mysql::command("SELECT * FROM {praefix}settingpoints WHERE type != '4'");
			while($setting = mysql_fetch_object($ergebnis)) {
				$context = Security::injection($_POST[$setting->setting]);
				Settings::update($setting->setting, $context);
			}
			HTML::greenBox("Die Einstellungen wurden erfolgreich gespeichert.");
		}




		echo "
		<p class=\"title\">System Einstellungen</p>
		<p class=\"text\">
			<form action=\"".Url::rewrite("page/admin/settings?save")."\" method=\"post\">";

		$ergebnis = Mysql::command("SELECT * FROM {praefix}settingpoints");
		while($setting = mysql_fetch_object($ergebnis)) {
			if($setting->type == 1) {
				echo "<p>$setting->title: <br /> <input type=\"text\" value=\"".htmlentities(Settings::get($setting->setting))."\" name=\"$setting->setting\" placeholder=\"".htmlentities($setting->title)."\"></p>";
			}
			elseif ($setting->type == 2) {
				echo "<p>$setting->title: <br /> <textarea name=\"$setting->setting\" style=\"margin-top: 10px;\" placeholder=\"$setting->title\">".htmlentities(Settings::get($setting->setting))."</textarea></p>";
			}
			elseif ($setting->type == 3) {
				echo "<p>$setting->title: <br />Ja <input type=\"radio\" name=\"$setting->setting\" value=\"1\" "; if(Settings::get($setting->setting)) { echo "checked";} echo "> / Nein <input type=\"radio\" name=\"$setting->setting\" value=\"0\" "; if(!Settings::get($setting->setting)) { echo "checked";} echo "></p>";
			}
			elseif ($setting->type == 4) {
				echo "<p>$setting->title: <br /> <input type=\"text\" value=\"".htmlentities(Settings::get($setting->setting))."\" name=\"$setting->setting\" placeholder=\"".htmlentities($setting->title)."\" readonly></p>";
			}
		}

		echo "<input type=\"submit\" value=\"speichern\" />
		</form>
		</p>";
	}

	function header() {

	}
}
?>