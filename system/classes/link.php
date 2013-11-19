<?php
class Link {
	static function generate($title) {
		$link = strtolower($title);
		$link = utf8_encode($link);
		$link = str_replace(' ', '-', $link);
		$link = str_replace("Ä", "ae", $link);
		$link = str_replace("Ö", "oe", $link);
		$link = str_replace("Ü", "ue", $link);
		$link = str_replace("ä", "ae", $link);
		$link = str_replace("ö", "oe", $link);
		$link = str_replace("ü", "ue", $link);
		$link = str_replace("?", "", $link);
		$link = str_replace("!", "", $link);
		$link = str_replace('"', "", $link);
		$link = str_replace(",", "", $link);
		$link = str_replace(".", "", $link);
		$link = str_replace("#", "", $link);
		$link = str_replace('--', "-", $link);
		$link = str_replace('---', "-", $link);
		return $link;
	}

	static function rework($text) {
		//Aus http://url wird [URL]http://url[/URL]
		$urlsuch[]="/([^]_a-z0-9-=\"'\/])((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";
		$urlsuch[]="/^((https?|ftp):\/\/|www\.)([^ \r\n\(\)\^\$!`\"'\|\[\]\{\}<>]*)/si";

		$urlreplace[]="\\1[URL]\\2\\4[/URL]";
		$urlreplace[]="[URL]\\1\\3[/URL]";

		//Aus klaus@mustermann.de wird [EMAIL]klaus@mustermann.de [/EMAIL]
		$emailsuch[]="/([\s])([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 
		$emailsuch[]="/^([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,}))/si"; 

		$emailreplace[]="\\1[EMAIL]\\2[/EMAIL]";

		$emailreplace[]="[EMAIL]\\0[/EMAIL]";

		$text = preg_replace($urlsuch, $urlreplace, $text);
		if (strpos($text, "@"))
		    {
		    $text = preg_replace($emailsuch, $emailreplace, $text);
		    }

		//Die URL's werden zu Links
		$text = preg_replace("/\[URL\]www.(.*?)\[\/URL\]/si", "<a  style=\"color: #2222FF;\" target=\"_blank\" href=\"http://www.\\1\">www.\\1</a>", $text);

		$text = preg_replace("/\[URL\](.*?)\[\/URL\]/si", "<a  style=\"color: #2222FF;\" target=\"_blank\" href=\"\\1\">\\1</a>", $text);

		$text = preg_replace("/\[URL=www.(.*?)\](.*?)\[\/URL\]/si", "<a  style=\"color: #2222FF;\" target=\"_blank\" href=\"http://www.\\1\">\\2</a>", $text);

		$text = preg_replace("/\[URL=(.*?)\](.*?)\[\/URL\]/si", "<a  style=\"color: #2222FF;\" target=\"_blank\" href=\"\\1\">\\2</a>", $text);

		//E-Mail Adressen werden zu links
		$text = preg_replace("/\[EMAIL\](.*?)\[\/EMAIL\]/si", "<a style=\"color: #2222FF;\" href=\"mailto:\\1\">\\1</a>", $text);

		$text = preg_replace("/\[EMAIL=(.*?)\](.*?)\[\/EMAIL\]/si", "<a href=\"mailto:\\1\">\\2</a>", $text);

		//[IMG]bild.jpg[/IMG] wird als Bild angezeigt
		$text = preg_replace("/\[IMG\](.*?)\[\/IMG\]/si", "<img src=\"\\1\" style=\"width: 50px;\" border=\"0\">", $text);
		if(Settings::pageData() != "/admin/editor") {
			$text = preg_replace("/src=\"(.*?)\"/si", 'src="'.url::rewrite("system/images/user/\\1").'"', $text);
		}
		return $text;
	}
}
?>