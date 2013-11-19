<?php
class Page_admin_new {
	function display() {
		$art = $_GET["art"];
		$kategorie = $_POST["kategorie"];
		$titel= $_POST["titel"];
		$beschreibung = $_POST["beschreibung"];
		$keywords = $_POST["keywords"];
		$text = $_POST["text"];

		if($art == "save")
		{
			if($titel != "" AND $kategorie != "" AND $text != "") {
				Article::NewArticle($kategorie, $titel, $beschreibung, $keywords, $text);
				HTML::greenBox("Eintrag gespeichert");
			}
			else
			{
				HTML::redBox("Es wurden nicht alle Felder ausgefüllt.");
			}
		}

		$template = new template;
		$template->load("new_article");
		$template->assignVar("SAVE_URL", Url::rewrite("page/admin/new?art=save"));
		$option = null;

		$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie");
		while($kategorie = mysql_fetch_object($ergebnis))
		{
			$option .= "<option value='$kategorie->id'>".$kategorie->q."</option>";
		}
		$template->assignVar("KATEGORIE", $option);
		$template->output();
	}

	function header() {

	}
}
?>