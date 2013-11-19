<?php
/**
* Extensions
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Extensions {
	private $name;
	private $path;
	private $description;
	private $authorName;
	private $authorLink;
	private $version;
	private $license;
	private $licenseUrl;
	private $docuUrl;
	private $dependence;
	private $data;
	private $return;

	function add($type)
	{
		if(!Extensions::checkExtension($this->path) && $this->checkDependence()) {
			Mysql::command("INSERT INTO {praefix}extensions
			(name, link, beschreibung, status, type, version, authorName, authorLink, license, licenseUrl, docuUrl, data, time)
			VALUES
			('$this->name', '$this->path', '$this->description', '', '$type', '$this->version', '$this->authorName',
			'$this->authorLink', '$this->license', '$this->licenseUrl', '$this->docuUrl', '$this->data', '".time()."')");
			if($type == "skin") {
				rename(BASEPATH."/system/temp/".$this->path, BASEPATH."/system/skins/".$this->path);
				$this->return = true;
			}
			else {
				rename(BASEPATH."/system/temp/".$this->path, BASEPATH."/system/extensions/".$this->path);
				$this->return = true;
			}
		}
		else {
			Upload::delDir("system/temp/".$this->path);
			$this->return = false;
		}
	}

	static function get($ext)
	{	
		$ext = Security::injection($ext);
		return Mysql::fetch_object("SELECT * FROM {praefix}extensions WHERE link='$ext'");
	}

	static function uninstall($ext)
	{
		$ext = Security::injection($ext);
		Extensions::updateStatus($ext, false);
		require_once "system/extensions/$ext/uninstall.php";
	}

	static function install($ext)
	{
		$ext = Security::injection($ext);
		require_once "system/extensions/$ext/install.php";
		Extensions::updateStatus($ext, true);
	}

	static function updateStatus($ext, $status)
	{
		$ext = Security::injection($ext);
		$status = Security::injection($status);
		return Mysql::command("UPDATE {praefix}extensions SET status = '$status' WHERE link ='$ext' LIMIT 1");
	}

	static function upload($file)
	{
		$infos = Upload::FileInfoTemp($file);
		Upload::safe($file, "system/temp/".$infos["name"], "zip|ZIP");
		Upload::unzip('system/temp/'.$infos["name"]);
		$name = explode(".", $infos["name"]);
		unlink('system/temp/'.$infos["name"]);
		$extension = new Extensions;
	 	require_once 'system/temp/'.$name[0].'/info.php';
	 	return $extension->return;
	}

	static function checkExtension($path)
	{
		$path = Security::injection($path);
		if(Mysql::count("SELECT COUNT(id) FROM {praefix}extensions WHERE link='$path' AND status = '1'") == 0) {
			return false;
		}
		else {
			return true;
		}
	}

	static function delete($ext)
	{
		$ext = Security::injection($ext);
		return Mysql::command("DELETE FROM {praefix}extensions WHERE link='$ext' AND status!='1'");
	}

	function checkDependence()
	{
		$dep = $this->dependence;
		for ($i=0; $i < count($dep); $i++) { 
			if(!$this->checkExtension($dep[$i])) {
				return false;
			}
		}
		return true;
	}

	static function urlUpload($url)
	{
		$filename = "#".time()."_".basename($url);
		$secondname = basename($url);
		$value = Upload::get($url);
		fwrite(fopen("system/temp/".$filename, "w"), $value);
		Upload::unzip('system/temp/'.$filename);
		unlink('system/temp/'.$filename);
		$name = explode(".", $secondname);
		require_once 'system/temp/'.$name[0].'/info.php';
	}
}
?>