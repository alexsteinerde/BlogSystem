<?php
class Article {
	static function relations($blog) {
		$article = 0;
		$return = "";
		$ergebnis1 = Mysql::command("SELECT * FROM {praefix}keywords_to WHERE article = '$blog'");
		while($blog_keywords = mysql_fetch_object($ergebnis1))
		{
			$ergebnis = Mysql::command("SELECT * FROM {praefix}keywords_to WHERE keyword = '$blog_keywords->keyword' AND article != '$blog'");
			while($keyword = mysql_fetch_object($ergebnis))
			{
				if($article <= 5)
				{
					$keyword_blog = Mysql::fetch_object("SELECT * FROM {praefix}article WHERE id = '$keyword->article' ORDER BY id DESC");

					$return .= "<a href=\"".Url::rewrite("article/".$keyword_blog->link)."\">$keyword_blog->titel</a><br />";
				}
				$article++;
			}
		}
		if($article == 0) {
			$return .= "Keine weiteren Artikel gefunden.";
		}
		return $return;
	}

	static function NewArticle($kategorie, $titel, $beschreibung, $keywords, $text) {
		$link = Link::generate($titel);
		$time = time();

		Mysql::command("INSERT INTO {praefix}article
		(titel, text, time, kategorie, beschreibung, link, autor, `show`)
		VALUES
		('$titel', '$text', '$time', '$kategorie', '$beschreibung', '$link', '".Login::getId(Session::get("login"))->mail."', '".Settings::get("article")."')");

		Mysql::command("INSERT INTO {praefix}activity
		(text, link, modus)
		VALUES
		('Ein Artikel wurde hinzugef&uumlgt.', 'page/admin/artikel', 'new')");

		$blog = Mysql::fetch_object("SELECT * FROM {praefix}article ORDER BY id DESC LIMIT 1");

		$keywords = explode(", ", trim($keywords));
		foreach($keywords AS $word)
	  	{
	  		$menge = Mysql::count("SELECT COUNT(id) FROM {praefix}keywords WHERE keyword = '$word'");

			if($menge == 0 AND $keywords != "") {
				$word = htmlentities($word);
				Mysql::command("INSERT INTO {praefix}keywords
				(keyword)
				VALUES
				('$word')");
			}

			$keyword_db = Mysql::fetch_object("SELECT * FROM {praefix}keywords WHERE keyword = '$word'");

				Mysql::command("INSERT INTO {praefix}keywords_to
				(article, keyword)
				VALUES
				('$blog->id', '$keyword_db->id')");
		}

		Event::start("new-article");
	}
}
?>