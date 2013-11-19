<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/

class SettingPoints {
	static function creat($title, $setting, $type, $default="")
	{
		$title = Security::injection($title);
		$setting = Security::injection($setting);
		$type = Security::injection($type);
		$default = Security::injection($default);

		Mysql::command("INSERT INTO {praefix}settingpoints (title, setting, type, `default`) VALUES ('$title', '$setting', '$type', '$default')");

		if($type == 1 || $type == 2 || $type == 4) {
			Settings::creat($setting, $default);
		}
		elseif ($type == 3) {
			Settings::creat($setting, 1);
		}
	}
	static function delet($setting, $type) {
		$setting = Security::injection($setting);
		$type = Security::injection($type);

		Mysql::command("DELETE FROM {praefix}settingpoints WHERE setting = '$setting' AND type = '$type'");

		Settings::delet($Setting);
	}
}
?>