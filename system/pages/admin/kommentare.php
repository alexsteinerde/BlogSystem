<?php
class Page_admin_kommentare {
	function display() {
		Activitys::see("kommetar");
		$art = Security::injection($_GET["art"]);
		$id = Security::injection($_GET["id"]);

		if($art == "on" AND $id != "")
		{
			Mysql::command("UPDATE {praefix}kommentare Set
			status='on' WHERE id = '$id'");
			HTML::greenBox("Kommentar freigegeben");
		}

		if($art == "del") {
			Mysql::command("DELETE FROM {praefix}kommentare WHERE id = '$id'");
			HTML::greenBox("Kommentar wurde erfolgreich gel&ouml;scht!");
		}
		echo "<p class=\"title\">Kommentare</p>
		<div class=\"text\">
		$status";
			$ergebnis = Mysql::command("SELECT * FROM {praefix}kommentare ORDER BY id DESC");
				while($kommentar = mysql_fetch_object($ergebnis))
				{
					echo "<div class=\"comment\">
						<div class=\"time\">
							".Time::timePast($kommentar->time)."
						</div>
						<p class=\"title\">".htmlentities($kommentar->name)." ($kommentar->myid) "; if($kommentar->status == "off") { echo "<a href=\"".Url::rewrite("page/admin/kommentare?art=on&id=$kommentar->id")."\">freigeben</a> / "; } echo "<a href=\"#\" class=\"del\" onclick=\"getPopup('.del', 'M&ouml;chtest du diesen Kommentar wirklich l&ouml;schen?', 'Ja', '".Url::rewrite("page/admin/kommentare?art=del&id=$kommentar->id")."');\">l&ouml;schen</a></p>
						<div class=\"text\" style=\"margin-top: 50px;\">
							".Link::rework(htmlentities($kommentar->text))."
							E-mail: ".htmlentities($kommentar->mail)."<br />
							Webseite: ".htmlentities($kommentar->webseite)."
						</div>
					</div>";
				}
				if(Mysql::count("SELECT COUNT(id) FROM {praefix}kommentare ORDER BY id DESC") == 0) {
					echo "<i>Es sind keine Kommentare vorhanden</i>";
				}
		echo "</div>";
	}

	function header() {

	}
}
?>