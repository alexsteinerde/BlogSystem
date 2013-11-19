<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
class Updater {
	private $source;
	private $version;
	private $sitecontent;
	private $update;
	private $type;
	function __construct($update="system")
	{
		$this->source = SOURCE;
		if($update == "system") {
			$this->version = Settings::get("version");
		}
		else {
			$this->version = @Extensions::get($update)->version;
		}
		$this->type = $update;
		$return = $this->get($this->source."?version=".$this->version."&cut=".$update);
		$this->getJson();
		return $return;
	}

	public function checkVariant()
	{
		if(ini_get('allow_url_fopen') != false){ 
			return 1001;
		} 
		else if (extension_loaded("curl")) {
			return 1002;
		}
		else {
			return false;
		}
	}

	public function get($url)
	{
		$check = $this->checkVariant();
		if($check == 1001) {
			$content = file_get_contents($url);
		}
		else if ($check == 1002) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$content = curl_exec($ch);
			curl_close($ch);
		}
		else {
			return $check;
		}
		$this->sitecontent = $content;
		return $content;
	}

	public function getJson()
	{
		$this->update = json_decode($this->sitecontent);
	}

	public function count()
	{
		return count($this->update);
	}

	public function decode($id)
	{
		return $this->update[$id];
	}

	public function download($id)
	{
		$update = $this->decode($id);
		$get = $this->get($update->url.$update->filename);
		fwrite(fopen("system/temp/updates/#".time().$this->type."_".$update->filename, "w"), $get);
	}

	public function downloadAll()
	{
		for ($i=0; $i < $this->count(); $i++) { 
			$this->download($i);
		}
	}

	public function install($filename)
	{	
		if($this->type == "system") {
			Upload::unzip("system/temp/updates/".$filename,"");
		}
		else {
			Upload::unzip("system/temp/updates/".$filename,"system/extensions/".$this->type."/");

		}
		$this->installFile();
		$this->updateVersion();
	}

	public function installAll()
	{
		$verz=opendir("system/temp/updates/"); 
		while($file = readdir($verz))  
		{  
		  if($file !="." && $file !=".." AND strpos($file, $this->type."_") != false)  
		  { 
		    $this->install($file);
		    unlink("system/temp/updates/".$file);
		  } 
		} 
		closedir($verz); 
	}

	private function updateVersion()
	{
		if($this->type == "system") {
			$newversion = file_get_contents(".update");
			Settings::update("version", $newversion);
			unlink('.update');
		}
		else {
			$newversion = file_get_contents("system/extensions/".$this->type."/.update");
			Settings::update("version", $newversion);
			unlink('system/extensions/".$this->type."/.update');
		}
	}

	private function installFile()
	{
		if($this->type == "system") {
			if(file_exists("system/temp/install.php")) {
				include_once 'system/temp/install.php';
				unlink('system/temp/install.php');
			}
		}
		else {
			if(file_exists("system/extensions/".$this->type."/temp/install.php")) {
				include_once 'system/extensions/".$this->type."/temp/install.php';
				unlink('system/extensions/".$this->type."/temp/install.php');
			}
		}
	}

	public function checkUpdate()
	{
		return $this->count();
	}
}
?>