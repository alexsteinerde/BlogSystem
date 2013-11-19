<?php
/**
* Autloader
*
* Bindet alle Klassen ein, die von den Scripten gebraucht werden.
*
* @package Systemfile
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
*/
function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$class_name = explode("_", $class_name);
	if(sizeOf($class_name) >= 2)
	{
		for ($i=2; $i < count($class_name); $i++) { 
			$classname[] = $class_name[$i];
		}
		$classname = @implode("_", $classname);
		if($class_name[0] == "page") {
			$pagedir = "";
			for ($i=1; $i < count($class_name); $i++) { 
				if($i != count($class_name)-1) {
					$pagedir .= $class_name[$i]."/";
				}
				else {
					$pagedir .= $class_name[$i].".php";
				}
			}
			include_once BASEPATH."/system/pages/$pagedir";
		}
		else if($class_name[0] == "ext") {
			include_once BASEPATH."/system/extensions/".$class_name[1]."/classes/".$classname.".php";
		}
		elseif($class_name[0] == "modul"){
			include_once BASEPATH."/system/module/".$class_name[1].".php";
		}
	}
	else {
   		include_once BASEPATH."/system/classes/".$class_name[0].".php";
   	}

}
?>