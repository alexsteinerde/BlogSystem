<?php
/**
* Request Datei für das Login
*
* @package Include
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
* @uses Session
* @uses Login
* @todo Auf Fehler prüfen
*/
if(empty($_POST["user"]) OR empty($_POST["pw"])) {
	echo "Bitte f&uuml;lle alle Felder aus";
}
else if(Login::log($_POST["user"], $_POST["pw"])) {
	echo "<div class=\"green\">Login war erfolgreich!</div>";
	echo "<meta http-equiv=\"refresh\" content=\"2; URL=".Url::rewrite("page/admin/home")."\">";
	Session::update("pageright", Login::getM($_POST["user"])->pageright);
	Session::creat("login", Login::getM($_POST["user"])->id);
}
else {
	echo "Dein Nutzername oder dein Passwort ist falsch. Bitte versuche es noch einmal.";
}
?>