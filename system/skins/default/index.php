<?php
$title = Pages::get(Settings::pageData())->title;
$klasse = Pages::get(Settings::pageData())->class;
$page = new $klasse;
$sidebar = new Sidebar;
echo "<!DOCTYPE html>
	<head>
		".Header::get()."
		<link rel=\"stylesheet\" href=\"".url::rewrite("system/skins/default/main.css")."\">
		<link rel=\"stylesheet\" href=\"".url::rewrite("system/css/main.css")."\">
		".$page->header()."
	</head>
	<body>
		<div class=\"wrapper\">
			<div class=\"top\">
				<a href=\"".Url::rewrite("page/home")."\">$title</a>
			</div>
			<div class=\"menu\">
				<ul>";
					echo Menu::get("<li>", "</li>");
				echo "</ul>
			</div>
			<div class=\"box\">
				<div class=\"content\">
					<div class=\"textdiv\">";
					$page->display();
					echo "</div>
					<div class=\"sidebar\">
						"; 
						$sidebar->get(); 
						echo "
					</div>
					<div align=\"center\" class=\"footer\">
						&copy; AlexBlog |
						".Header::footer()."
					</div>
				</div>
			</div>
		</div>
	</body>
</html>";
?>