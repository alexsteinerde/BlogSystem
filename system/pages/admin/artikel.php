<?php
class Page_admin_artikel {
	function display() {
		Activitys::see("new_article");
		$seite = Security::injection($_GET["seite"]);
		$art = Security::injection($_GET["art"]);
		$id = Security::injection($_GET["id"]);
		$time = time();

		if($art == "save" AND $id != "")
		{
			Mysql::command("UPDATE {praefix}article Set
			`show`='1', time='$time' WHERE id = '$id'");
			HTML::greenBox("Der Artikel wurde erfolgreich veröffentlich");
		}

		if($art == "del" AND $id != "" AND Login::getId(Session::get("login"))->functionright >= 5)
		{
			Mysql::command("DELETE FROM {praefix}article WHERE id = '$id'");

			Mysql::command("DELETE FROM {praefix}keywords_to WHERE article = '$id'");
			HTML::greenBox("Der Artikel wurde erfolgreich entfernt");
		}

		//Blätterfunktion
		if($seite == "")
		   {
		   $seite = 1;
		   }
		$eintraege_pro_seite = 15;
		$start = $seite * $eintraege_pro_seite - $eintraege_pro_seite; 

		//Main
		echo "<p class=\"title\">Artikel</p>
		<div class=\"text\">";
			$ergebnis = Mysql::command("SELECT * FROM {praefix}article ORDER BY time DESC LIMIT $start, $eintraege_pro_seite");
			while($blog = mysql_fetch_object($ergebnis))
			{
				$ergebnis1 = Mysql::command("SELECT * FROM {praefix}kategorie WHERE id = '$blog->kategorie'");
				$kategorie = mysql_fetch_object($ergebnis1);

				echo "<div class=\"time\" >
							".Time::timePast($blog->time)."
					</div>
				<b class=\"title\">$blog->titel</b> <a href=\"".Url::rewrite("page/admin/editor?id=$blog->id")."\">bearbeiten</a> / <a href=\"#\" class=\"del\" onclick=\"getPopup('.del', 'M&ouml;chtest du diesen Artikel wirklich l&ouml;schen?', 'Ja', '".Url::rewrite("page/admin/artikel?id=$blog->id&art=del")."');\">l&oumlschen</a>"; if(!$blog->show) {echo " / <a href=\"#\" class=\"up\" onclick=\"getPopup('.up', 'M&ouml;chtest du diesen Artikel wirklich freigeben?', 'Ja', '".Url::rewrite("page/admin/artikel?id=$blog->id&art=save")."');\">freigeben</a>";}
				echo "<div class=\"text\" style=\"margin-bottom: 20px;\">
					<textarea>".Link::rework($blog->beschreibung)." - ".Url::rewrite("article/$blog->link")."</textarea>
					<br>
					<i style=\"margin-top: 5px;\">Dieser Beitrag ist in die Kategorie <b>$kategorie->q</b> eingeordnet.</i>
				</div>";
			}
			if(Mysql::count("SELECT COUNT(id) FROM {praefix}article") == 0 ) {
				echo "<i>Es sind keine Artikel vorhanden</i>";
			}
			else {
				$result = Mysql::command("SELECT * FROM {praefix}article"); 
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
				echo "  <a href=\"".url::rewrite("page/admin/artikel?seite=$b")."\" style=\"color: #2222FF;\">$b</a> "; 
				} 
				}
			}
		echo "</div>";
	}

	function header() {

	}
}
?>