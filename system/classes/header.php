<?php
/**
* Header/Footer der Seiten
*
* Enthält den Header und den Footer für die anzuzeigenen Dateien.
*
* @package  Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Header {
	/**
	* Ausgabe des Headers
	*@return string HTML Header
	* @uses Pages::get()
	* @uses Settings::get()
	* @uses Settings::pageData()
	* @uses Url::rewrite()
	*/
	static function get()
	{
		Event::start("header");
		$page = Pages::get(Settings::pageData())->title;
		return "<title>".htmlentities($page)." - ".htmlentities(Settings::get("title"))."</title>
		<meta chasret=\"utf-8\">
		<meta http-equiv=\"content-language\" content=\"de\">
		<meta name=\"revisit-after\" content=\"1 days\">
		<link rel=\"shortcut icon\" href=\"".Url::rewrite("system/images/favicon.ico")."\" />
		<link rel=\"apple-touch-icon\" href=\"".Url::rewrite("system/images/apple-icon/iphone.png")."\" />
		<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"".Url::rewrite("system/images/apple-icon/iphone4.png")."\" />
		<link rel=\"stylesheet\" href=\"".Url::rewrite("system/css/popup.css")."\">
		<script type=\"text/javascript\" src=\"".Url::rewrite("system/js/jquery.js")."\"></script>
		<script type=\"text/javascript\" src=\"".Url::rewrite("system/js/jquery.popup.min.js")."\"></script>";
	}

	/**
	* Footer festlegen
	* @return string Gibt Footer zurück.
	*/
	static function footer()
	{
		return "powered by <a href=\"http://www.alexsteiner.de\" target=\"_blank\">Alex Steiner</a>";
	}
}
?>