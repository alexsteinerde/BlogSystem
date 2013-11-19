<?php
class Page_categorie {
	function display() {
		$categorie = Security::injection(@$_GET["categorie"]);

		if($categorie != "")
		{
			$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie WHERE id = '$categorie'");
			$kategorie = mysql_fetch_object($ergebnis);

			echo "<b class=\"title\" style=\"font-size: 25px;\">$kategorie->q</b>
			<div class=\"text\" style=\"margin-bottom: 20px;\">
				$kategorie->description
			</div>";
			$ergebnis = Mysql::command("SELECT * FROM {praefix}article WHERE kategorie = '$categorie' AND `show` = '1' ORDER BY time DESC");
			while($blog = mysql_fetch_object($ergebnis))
			{
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
		}
		else {
			$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie");
			while($blog = mysql_fetch_object($ergebnis))
			{
				$while_ergebnis = Mysql::command("SELECT COUNT(id) FROM {praefix}article WHERE kategorie = '$blog->id'");
				$menge = mysql_fetch_row($while_ergebnis);
				$menge = $menge[0];
				if($menge != 0)
				{
				$text = Link::rework($blog->description);
				echo "<a href=\"".Url::rewrite("page/categorie?categorie=$blog->id")."\" class=\"title\"><b>".htmlentities($blog->q)."</b></a>
				<div class=\"text\" style=\"margin-bottom: 20px;\">
					$text
				</div>";
				}
			}

		}
	}

	function header() {
		echo "<link rel=\"canonical\" href=\"".Url::rewrite("page/categorie")."\"/>";
	}
}
?>