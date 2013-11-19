<?php
class Page_admin_home {
	function display() {
		$user = Session::get("login");
		$art = @$_GET["art"];

		if($art == "user_logout") {
			Login::logout();
			echo "<meta http-equiv=\"refresh\" content=\"0; URL=".Url::rewrite("page/home")."\">";
		}

		if($art == "del" AND Login::getId($user)->functionright >= 2)
		{
			Mysql::command("DELETE FROM {praefix}activity");
			HTML::greenbox("Aktivitäten wurden erfolgreich gelöscht");
		}

		echo "<p class=\"title\">Aktivit&auml;ten</p>
		<div class=\"text\" style=\"height: 200px; overflow: auto;\" id=\"modul\">
			<ul>";
				$ergebnis = Mysql::command("SELECT * FROM {praefix}activity ORDER BY id DESC");
				while($timeline = Mysql_fetch_object($ergebnis))
				{
					if($timeline->status == "")
					{
						echo "<li><b><a href=\"$timeline->link\" style=\"color: #000000;\" tareget>$timeline->text</a></b></li>";
					}
					else
					{
						echo "<li><a href=\"$timeline->link\" style=\"color: #000000;\" tareget>$timeline->text</a></li>";
					}
				}
			echo "</ul>
			<a href=\"#\" class=\"delall\" onclick=\"getPopup('.delall', 'M&ouml;chtest du den Verlauf wirklich l&ouml;schen?', 'Ja', '".Url::rewrite("page/admin/home?art=del")."');\">Verlauf l&ouml;schen</a>
		</div>";
		Event::start("modul");
	}

	function header() {
		echo "<script>
		function update(type, data) {
			$.post(\"".Url::rewrite("system/update/update.php")."\",
			{
			key: \"S[_{kwZ#y#\",
			type: type,
			data: data,
			},
			function(data){
			$('.updater').html(data);
			});
		}
		function updateinstall(data) {
			$.post(\"".Url::rewrite("update.php")."\",
			{
			key: \"S[_{kwZ#y#\",
			data: data,
			},
			function(data){
			$('.updater').html(data);
			});
		}
		</script>";
	}
}
?>