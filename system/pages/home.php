<?php
class Page_home {
	function display() {
		$ergebnis_while = Mysql::command("SELECT * FROM {praefix}article WHERE `show` = '1' ORDER BY time DESC LIMIT 5");
		while($blog = mysql_fetch_object($ergebnis_while))
		{
			$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie WHERE id = '$blog->kategorie'");
			$kategorie = mysql_fetch_object($ergebnis);
			echo "<div class=\"article\">
				<div class=\"time\">
							".Time::timePast($blog->time)."
					</div>
				<p class=\"title\">$blog->titel</p>
				<div class=\"text\">
					".Link::rework($blog->beschreibung)."... <a href=\"".Url::rewrite("article/$blog->link")."\">Weiter lesen</a>
					<br><br>
					<i style=\"margin-top: 5px;\">Kategorie: <a href=\"".Url::rewrite("page/categorie?categorie=$blog->kategorie")."\"><b>".htmlentities($kategorie->q)."</b></a>, Autor: <b>".htmlentities($blog->autor)."</b></i>
				</div>
			</div>";
		}
		echo "<br /><a href=\"".Url::rewrite("page/archiv")."\" class=\"cssbutton\">Weiter Artikel</a>";
	}

	function header() {

	}
}
?>