<?php
/**
* Allgemeine Upload Klasse
*
* Geift auf die Tabelle "{praefix}upload" zu und kann dort Uploads speichern.
*
* @package Classes
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
class Upload {
	/**
	* Sicherer Upload
	* @param array $file Hochgeladene Datei(mit $_FILE).
	* @param string $path Pfad, wo die Datei gespeichert werden soll.
	* @param string $type Dateiendungen, die zugelassen sind. Am besten einmal alles klein geschrieben und einmal alles groß geschrieben. Einzelen Endungen werden mit | getrennt.
	* @param integer $maxsize Maximale Uploadgröße in Byte(Standart ist 5242880B/5MB)
	* @return boolean true|false
	*/
	static function safe($file, $path, $type, $maxsize=5242880)
	{
		$allowed_types = "($type)";
		if(preg_match("/\." . $allowed_types . "$/i", strtolower($file["name"])))
		{
			if($file['size'] <  $maxsize)
			{
				move_uploaded_file($file['tmp_name'], $path);
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	* Unsicherer Upload
	* @param array $file Hochgeladene Datei(mit $_FILE).
	* @param string $path Pfad, wo die Datei gespeichert werden soll.
	* @return boolean true|false
	*/
	static function unsafe($file, $path)
	{
		move_uploaded_file($file['tmp_name'], $path);
		if($file["error"] == 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Upload-Datei Informationen auslesen
	* @param array $file Hochgeladene Datei(mit $_FILE).
	* @return array Gibt Array mit folgenden Informationen zurück: "type,extension,name,size,status"
	*/
	static function fileInfoTemp($file)
	{
		$filetype = $file['type'];
		$fileextension = pathinfo($file['name']);
		$fileextension = $fileextension['extension'];

		$fileinfo = array('type' => $filetype, 'extension' => $fileextension, 'name' => $file['name'], 'size' => $file["size"], 'status' => $file['error']);
		return $fileinfo;
	}

	/**
	* Liest Informationen über Hochgeladene Datei aus Datenbank aus.
	* @param integer $id ID der Hochgeladenen Datei.
	* @return array|false
	* @uses Security::injection()
	* @uses Mysql::command()
	*/
	static function getInfoId($id)
	{
		$id = Security::injection($id);
		return Mysql::fetch_object("SELECT * FROM {praefix}upload WHERE id = '$id' LIMIT 1");
	}

	/**
	* Prüft, ob der jetzige User die passenden Rechte hat, um die Datei einzusehen.
	* @param integer $fileid Id der Datei, deren Rechte geprüft werden sollen.
	* @return integer 200|403|404|406|416 Fehlercode. 200=OK, 403=Rechte, 404 Datei nicht gefunden, 406=Datei nicht in der Datenbank, 416=$fileid ist leer
	* @uses Security::injection()
	* @uses Mysql::command()
	* @uses Session::get()
	* @uses Upload::getInfoId()
	*/
	static function checkRight($fileid) //Rechte für den Download checken
	{
		$fileid = Security::injection($fileid); //Absichern
		
		$file = Upload::getInfoId($fileid);
		if(!file_exists("system/upload/".$file->filepath.$file->filename))
		{
			return 404;
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}upload WHERE id = '$fileid'") == 0) {
			return 406;
		}
		elseif(!Mysql::count("SELECT COUNT(id) FROM {praefix}uploadright WHERE file = '$fileid' AND `right` LIKE 'G-%'") == 0) {
			$group = Mysql::fetch_object("SELECT * FROM {praefix}uploadright WHERE file = '$fileid' AND `right` LIKE 'G-%'");
			$right = explode("G-", $group->right);
			$right = $right[1];
			if(!Mysql::count("SELECT COUNT(id) FROM {praefix}groupsfollower WHERE `group` = '$right' AND user = '".Session::get("login")."'") == 0) {
				return 200;
			}
			else {
				return 403;
			}
		}
		elseif(Mysql::count("SELECT COUNT(id) FROM {praefix}uploadright WHERE file = '$fileid' AND `right` = '".Session::get("pageright")."'") == 0) {
			return 403;
		}
		else {
			return 200;
		}
	}

	static function unzip($file, $target="system/temp/"){
	    $zip=zip_open($file);
	    if(!$zip) {return("Unable to proccess file '{$file}'");}

	    $e='';

	    while($zip_entry= zip_read($zip)) {
	       $zdir=dirname($target.zip_entry_name($zip_entry));
	       $zname=zip_entry_name($zip_entry);

	       if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}
	       if(!is_dir($zdir))Upload::mkdirr($zdir,0777);

	       #print "{$zdir} | {$zname} \n";

	       $zip_fs=zip_entry_filesize($zip_entry);
	       if(empty($zip_fs)) continue;

	       $zz=zip_entry_read($zip_entry,$zip_fs);

	       $z=fopen($target.$zname,"w");
	       fwrite($z,$zz);
	       fclose($z);
	       zip_entry_close($zip_entry);

	    } 
	    zip_close($zip);

	    return($e);
	} 

	static function mkdirr($pn,$mode=null) {

	  if(is_dir($pn)||empty($pn)) return true;
	  $pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);

	  if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}

	  $next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
	  if(Upload::mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
	  return false;
	}

	static function xCopy($dir, $newdir)
	{
		if(!file_exists($newdir)) {
			mkdir($newdir);
		}
		$scandir = scandir($dir);
		for ($i=2; $i < count($scandir); $i++) {
			$scanfile = $scandir[$i];
			if($scanfile != "." OR $scanfile != "..") {
				if(is_dir($dir."/".$scanfile) === true) {
					@mkdir($newdir.$dir."/".$scanfile);
					Upload::xCopy($dir."/".$scanfile, $newdir."/".$scanfile);
				}
				else {
					copy($dir."/".$scanfile, $newdir."/".$scanfile);
				}
			}
		}
	}

	static function delDir($f) {
	    if (is_dir($f)) {
	        foreach(glob($f.'/*') as $sf) {
	         if (is_dir($sf) && !is_link($sf)) {
	            Upload::delDir($sf);
	            } else {
	                unlink($sf);
	            }
	        }
	        }
	    rmdir($f);
	} 

	static function checkDir($dir)
	{
		$files = array();
		$verz=opendir($dir); 
		while($file = readdir($verz))  
		{  
		  if($file !="." && $file !="..")  
		  { 
		    $files[] = $file;
		  } 
		} 
		closedir($verz); 
		if(count($files) == 0) {
			return false;
		}
		else {
			return $files;
		}
	}

	static function checkVariant()
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

	static function get($url)
	{
		$check = Upload::checkVariant();
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
		return $content;
	}
}
?>