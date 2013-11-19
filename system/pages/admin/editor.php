<?php
class Page_admin_editor {
	function display() {
		Activitys::see("text");
		$id = Security::injection(@$_GET["id"]);
		$art = Security::injection(@$_GET["art"]);
		$titel = Security::injection(@$_POST["titel"]);
		$kategorie = Security::injection(@$_POST["kategorie"]);
		$link = Security::injection(@$_POST["link"]);
		$beschreibung = Security::injection(@$_POST["beschreibung"]);
		$text = $_POST["text"];

		if($art == "save" AND $id != "")
		{
			Mysql::command("UPDATE {praefix}article Set
			titel='$titel', link='$link', kategorie='$kategorie', beschreibung='$beschreibung', text='$text' WHERE id = '$id'");

			Mysql::command("INSERT INTO {praefix}activity
			(text, link, modus)
			VALUES
			('Ein Artikel wurde bearbeitet.', 'editor.php?id=$id', 'text')");

			$status = "&Aumlnderungen gespeichert<br><br>";
		}

		$ergebnis = Mysql::command("SELECT * FROM {praefix}article WHERE id = '$id'");
		$blog = mysql_fetch_object($ergebnis);

		echo "<a href=\"".Url::rewrite("page/admin/artikel")."\">Zur&uumlck</a>
		<p class=\"title\">Editor</p>
		<div class=\"text\">
			<form action=\"".url::rewrite("page/admin/editor?id=$id&art=save")."\" method=\"post\">
				Titel: <input type=\"text\" name=\"titel\" value=\"$blog->titel\" style=\"margin-top: 10px;\"/> / 
				Link: <input type=\"text\" name=\"link\" value=\"$blog->link\" style=\"margin-top: 10px;\"/>
				Kategorie: <select name=\"kategorie\" size=\"1\">";

				$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie");
				while($kategorie = mysql_fetch_object($ergebnis))
				{
					echo "<option value=\"$kategorie->id\" ";if($blog->kategorie == $kategorie->id) {echo "selected";} echo ">$kategorie->q</option>";
				}
				echo "</select><br />
				<textarea name=\"beschreibung\" style=\"margin-top: 10px;\">$blog->beschreibung</textarea>
				<textarea class=\"ckeditor\" cols=\"80\" id=\"editor1\" name=\"text\">".Link::rework($blog->text)."</textarea><br>
				<input type=\"submit\" value=\"speichern\" />
			</form>

</div>";
	}

	function header() {

	}
}
?>