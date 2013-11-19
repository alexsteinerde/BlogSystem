<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
class Sidebar {
	static function get() {
		$ergebnis = Mysql::command("SELECT * FROM {praefix}extensions WHERE type = 'sidebar' AND status='1' ORDER BY time");
		while($sidebar = mysql_fetch_object($ergebnis)) {
			$class = "ext_".$sidebar->link."_sidebar";
			$classsecond = new $class;
			$classsecond->get();
		}
	}
}

?>