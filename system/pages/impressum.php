<?php
class  Page_impressum {
	function display() {
		$impressum = $about = Link::rework(nl2br(Settings::get("impressum")));
		$impressum = html_entity_decode($impressum);
		$template = new template;
		$template->load("default");
		$template->assignVar("TITLE", "Impressum");
		$template->assignVar("TEXT", $impressum);
		$template->output();
	}

	function header() {

	}
}
?>