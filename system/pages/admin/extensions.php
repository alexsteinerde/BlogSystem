<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
class Page_admin_extensions {
	function display() {
		if(isset($_GET["ext"]) AND empty($_POST["url"])) {
			$test = Extensions::upload($_FILES["ext"]);
			if($test != false)
			{
				HTML::greenBox("Die Erweiterung wurde erfolgreich eingespielt.");
			}
			else {
				HTML::redBox("Es ist ein Fehler aufgetaucht. Bitte versuchen sie es erneut.");
			}
		}
		elseif (isset($_GET["ext"]) AND !empty($_POST["url"])) {
			if(Extensions::urlUpload($_POST["url"]))
			{
				HTML::greenBox("Das Plugin wurde erfolgreich eingespielt.");
			}
			else {
				HTML::redBox("Es ist ein Fehler aufgetaucht. Bitte versuchen sie es erneut.");
			}
		}
		$template = new template;
		$template->load("admin_extensions");
		$template->assignVar("FORM_URL", Url::rewrite("page/admin/extensions"));
		$template->output();
	}

	function header() {
		$template = new template;
		$template->load("admin_extensions_js");
		$template->assignVar("URL", Url::rewrite("include/admin_extensions.php"));
		$template->assignVar("UPDATE_SKIN_URL", Url::rewrite("include/admin_extensions_update.php"));
		$template->output();
	}
}
?>