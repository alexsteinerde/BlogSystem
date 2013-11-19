<?php
class Page_article {
	function display() {
		$article = Security::injection($_GET["article"]);

		$ergebnis = Mysql::command("SELECT COUNT(id) FROM {praefix}article WHERE link = '$article'");
		$menge = mysql_fetch_row($ergebnis);
		$menge = $menge[0];
		if($menge == 0)
		{
		header("Location:".Url::rewrite("page/error")); 
		exit;
		}

		$ergebnis = Mysql::command("SELECT * FROM {praefix}article WHERE link = '$article' AND `show` = '1'");
		$blog = mysql_fetch_object($ergebnis);

		$ergebnis = Mysql::command("SELECT * FROM {praefix}kategorie WHERE id = '$blog->kategorie'");
		$kategorie = mysql_fetch_object($ergebnis);

		$template = new template;
		$template->load("article");
		$template->assignVar("BLOG_TIMEPAST", Time::timePast($blog->time));
		$template->assignVar("BLOG_TITLE", $blog->titel);
		$template->assignVar("BLOG_TEXT", Link::rework($blog->text));
		$template->assignVar("KATEGORIE_LINK", Url::rewrite("page/categorie?categorie=$blog->kategorie"));
		$template->assignVar("KATEGORIE", htmlentities($kategorie->q));
		$template->assignVar("AUTOR", htmlentities($blog->autor));
		$template->assignVar("MORE_ARTICLE", Article::relations($blog->id));
		$template->assignVar("COMMENT_FORM", url::rewrite("page/comment?id=$blog->id"));

			$ergebnis = Mysql::command("SELECT * FROM {praefix}kommentare WHERE myid = '$blog->id' AND `status` = 'on' ORDER BY id");
			while($kommentar = mysql_fetch_object($ergebnis))
			{
				 if($kommentar->webseite == "") {
				 	$name = "<p class=\"title\">".htmlentities($kommentar->name)."</p>";
				 }
				 else {
				 	$name = "<p class=\"title\"><a href=\"".htmlentities($kommentar->webseite)."\">".htmlentities($kommentar->name)."</a></p>";
				 }
				$comment = $template->addLoopItem("COMMENT");
				$comment = $template->assignLoopVar($comment, "COMMENT_TIMEPAST", Time::timePast($kommentar->time));
				$comment = $template->assignLoopVar($comment, "PICTURE", Url::rewrite("system/images/profilbild.png"));
				$comment = $template->assignLoopVar($comment, "NAME", $name);
				$comment = $template->assignLoopVar($comment, "COMMENT_TEXT", Link::rework(nl2br(htmlentities($kommentar->text))));
				$template->getLoop($comment);
			}
		$template->output();
	}

	function header() {

	}
}
?>