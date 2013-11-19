<?php
class Page_admin_categorie {
	function display() {
		$art = Security::injection($_GET["art"]);
		$id = Security::injection($_GET["id"]);
		$name = Security::injection($_POST["name"]);
		$text = Security::injection($_POST["text"]);

		if($art == "save" AND $name != "")
		{
			Mysql::command("INSERT INTO {praefix}kategorie
			(q, description)
			VALUES
			('$name', '$text')");
			//HTML::greenbox("Die Kategorie wurde erfolgreich hinzugef&uuml;gt");
		}

		if($art == "del" AND $id != "")
		{
			$count = Mysql::count("SELECT COUNT(id) FROM {praefix}kategorie");
			if($count > 1) {
				Mysql::command("DELETE FROM {praefix}kategorie WHERE id = '$id'");
				HTML::greenbox("Die Kategroie wurde erfolgreich entfernt");
			}
			else {
				HTML::redbox("Es muss mindestens immer eine Kategorie vorhanden sein!");
			}
		}
		echo "<p class=\"title\">Kategorien</p>
		<div class=\"text\">
			<form action=\"?art=save\" method=\"post\">
				Neue Kategorie hinzuf&uumlgen: <input type=\"text\" name=\"name\" placeholder=\"Name\"><br />
				Beschreibung:<br /> <textarea name=\"text\"></textarea><br />
				<input type=\"submit\" value=\"speichern\">
			</form>
			<ul>";
				$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie");
				while($kategorie = mysql_fetch_object($ergebnis))
				{
					echo "<li>".htmlentities($kategorie->q)." (<a href=\"#\" class=\"del\" onclick=\"getPopup('.del', 'M&ouml;chtest du diese Kategorie wirklich l&ouml;schen?', 'Ja', '".Url::rewrite("page/admin/categorie?art=del&id=$kategorie->id")."');\">l&ouml;schen</a>)
					<div class=\"text\" style=\"margin-bottom: 20px;\">
					".htmlentities($kategorie->description)."
					</div></li>";
				}
			echo "</ul>
		</div>";
	}

	function header() {

	}
}
?>