<?php
class Page_admin_impressum {
	function display() {
		$art = Security::injection($_GET["art"]);
		$text = Security::injection($_POST["text"]);

		if($art == "save" AND $text != "")
		{
			if(Settings::update("impressum", $text)) {
				HTML::greenBox("Das Impressum wurde erfolgreich ge&auml;ndert.");
			}
			else {
				HTML::reddBox("Es ist ein Fehler aufgetrete. Versuche es erneut.");
			}
		}
		echo "<p class=\"title\">Impressum</p>
		<div class=\"text\">
			<form action=\"".url::rewrite("page/admin/impressum?art=save")."\" method=\"post\">
				<textarea name=\"text\" class=\"ckeditor\" cols=\"80\" id=\"editor1\" style=\"margin-top: 10px;\" placeholder=\"Text\">".Settings::get("impressum")."</textarea><br>
				<input type=\"submit\" value=\"speichern\" />
			</form>
		</div>";
	}

	function header() {

	}
}
?>