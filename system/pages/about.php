<?php
class Page_about {
	function display() {
		$about = Link::rework(nl2br(Settings::get("about")));
		$about = html_entity_decode($about);
		$template = new template;
		$template->load("default");
		$template->assignVar("TITLE", "&Uuml;ber mich");
		$template->assignVar("TEXT", $about);
		$template->output();
	}
	
	function header() {

	}
}
?>