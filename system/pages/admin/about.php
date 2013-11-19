<?php
class Page_admin_about {
	function display() {
		$art = Security::injection($_GET["art"]);
		$text = Security::injection($_POST["text"]);

		if($art == "save" AND $text != "")
		{
			if(Settings::update("about", $text)) {
				HTML::greenBox("Die Seite '&Uuml;ber mich' wurde erfolgreich geändert.");
			}
			else {
				HTML::reddBox("Es ist ein Fehler aufgetrete. Versuche es erneut.");
			}
		}

		echo "<p class=\"title\">&Uumlber mich</p>
		<div class=\"text\">
			<form action=\"?art=save\" method=\"post\">
				<textarea name=\"text\" class=\"ckeditor\" cols=\"80\" id=\"editor1\" style=\"margin-top: 10px;\" placeholder=\"Text\">".Settings::get("about")."</textarea><br>
				<input type=\"submit\" value=\"speichern\" />
			</form>
		</div>";
	}

	function header() {

	}
}
?>