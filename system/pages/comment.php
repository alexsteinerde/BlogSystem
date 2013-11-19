<?php
class Page_comment {
	function display() {
		$name = Security::injection($_POST["name"]);
		$text = Security::injection($_POST["text"]);
		$mail = Security::injection($_POST["mail"]);
		$email = Security::injection($_POST["email"]);
		$website = Security::injection($_POST["website"]);
		$abcspam = Security::injection($_POST["abcspam"]);
		$seite = Security::injection($_SERVER["HTTP_REFERER"]);
		$id = Security::injection($_GET["id"]);
		$time = time();

		if($name != "" AND $text != "" AND $mail != "" AND $email == "" AND $abcspam == "spam#*" AND strlen($name) > 2)
		{
			Mysql::command("INSERT INTO {praefix}kommentare
			(myid, name, mail, webseite, text, time, status)
			VALUES
			('$id', '$name', '$mail', '$website', '$text', '$time', 'off')");

				Mysql::command("INSERT INTO {praefix}activity
				(text, link, modus)
				VALUES
				('Ein Artikel wurde kommentiert.', '".Url::rewrite("admin/kommentare")."', 'kommentar')");
			$status = "ok";
		}

		echo "<p class=\"title\">Kommenatar</p>
		<div class=\"text\">";

			if($status == "ok")
			{
				echo "Danke sch&oumln f&uumlr deinen Kommentar. Er wird in den n&aumlchsten 24 Stunden freigeschaltet. ";
			}
			else
			{
				echo "Es ist mindestens ein <b>Fehler</b> aufgetreten:<br><br>";
				if($name == "" OR strlen($name) < 3)
				{
					echo "Es ist kein Name angegeben oder er ist k&uumlrzer, als 3 Zeichen.<br>";
				}
				if ($text == "")
				{
					echo "Das Textfeld ist leer.<br>";
				}
				if (empty($mail)) {
					echo "Es ist keine E-mail Adresse angegeben.<br />";
				}
			}
		echo "</div>";
	}

	function header() {

	}
}
?>