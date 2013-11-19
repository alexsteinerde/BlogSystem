<?php
class Page_archiv {
	function display() {
		//Blätterfunktion
		$seite = @$_GET["seite"];
		if(!isset($seite))
		   {
		   $seite = 1;
		   }
		$eintraege_pro_seite = 15;
		$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;

		$ergebnis = Mysql::command("SELECT * FROM {praefix}article WHERE `show` = '1' ORDER BY time DESC LIMIT $start, $eintraege_pro_seite");
		while($blog = mysql_fetch_object($ergebnis))
		{
			$ergebnis1 = Mysql::command("SELECT * FROM {praefix}kategorie WHERE id = '$blog->kategorie'");
			$kategorie = mysql_fetch_object($ergebnis1);

			$template = new template;
			$template->load("archiv");
			$template->assignVar("TIMEPAST", Time::timePast($blog->time));
			$template->assignVar("TITLE", $blog->titel);
			$template->assignVar("BESCHREIBUNG", Link::rework($blog->beschreibung));
			$template->assignVar("BLOG_LINK", Url::rewrite("article/$blog->link"));
			$template->assignVar("KATEGORIE_LINK", Url::rewrite("page/categorie?categorie=$blog->kategorie"));
			$template->assignVar("KATEGORIE", htmlentities($kategorie->q));
			$template->assignVar("AUTOR", htmlentities($blog->autor));
			$template->output();
		}
			$result = Mysql::command("SELECT * FROM {praefix}article WHERE `show` = '1'");
			$menge = mysql_num_rows($result);
			$wieviel_seiten = $menge / $eintraege_pro_seite;

			echo "<div align=\"right\" style=\"font-size: 20px; margin-top: 10px;\">";
			echo "<b>Seite:</b> ";
			for($a=0; $a < $wieviel_seiten; $a++)
			{
			$b = $a + 1;

			//Wenn der User sich auf dieser Seite befindet, keinen Link ausgeben
			if($seite == $b)
			{
			echo "  <b>$b</b> ";
			}

			//Aus dieser Seite ist der User nicht, also einen Link ausgeben
			else
			{
			echo "  <a href=\"".Url::rewrite("page/archiv?seite=$b")."\" style=\"color: #2222FF;\">$b</a> ";
			}
			}
		echo "</div>";
	}

	function header() {
		echo "<link rel=\"canonical\" href=\"".Url::rewrite("page/archiv")."\"/>";
	}
}
?>