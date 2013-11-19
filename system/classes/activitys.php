<?php
/**
* Systemactivitys
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Activitys {
	static function see($group) {
		$group = Security::injection($group);
		return Mysql::command("UPDATE {praefix}activity SET status = 'see' WHERE group = '$group'");
	}
}
?>