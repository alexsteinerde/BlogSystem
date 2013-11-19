<?php
class  Page_search {
	function display() {
		$q = Security::injection(@$_GET["q"]);
		$abfrage = "SELECT COUNT(id) FROM {praefix}article WHERE beschreibung LIKE '%$q%' AND `show` = '1'";
		$ergebnis = Mysql::command($abfrage);
		$menge = mysql_fetch_row($ergebnis);
		$menge = $menge[0];

		if($menge == 0 OR empty($q))
		{
			echo "<p class=\"title\">Suche</p>
			<div class=\"text\">
				Leider kein Treffer. Probiere es nocheinmal!
			</div>";
		}
		else
		{
			$abfrage = "SELECT * FROM {praefix}article WHERE beschreibung LIKE '%$q%' AND `show` = '1' ORDER BY time DESC";
			$ergebnis = Mysql::command($abfrage);
			while($blog = mysql_fetch_object($ergebnis))
			{
				$text = Link::rework($blog->beschreibung);
				$datum = Time::timePast($blog->time);
				echo "<div class=\"time\" >
							$datum
					</div>
				<a href=\"".Url::rewrite("article/$blog->link")."\" class=\"title\">$blog->titel</a>
				<div class=\"text\" style=\"margin-bottom: 20px;\">
					$text
				</div>";
			}
		}
	}

	function header() {

	}
}
?>