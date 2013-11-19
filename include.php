<?php
/**
* Dateien einbinden. 
*
* Wenn man das Framwork über die URL /include/DATEINAME MIT ENDUNG aufruft wird diese Datei im Hintergrund aufgerufen und includiert die angegebene Datei.
*
* @package Systemfile
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
* @version 0.1 alpha
* @uses Mysql::command()
* @uses Event::start()
*/
require_once 'config.php';
include(BASEPATH."/system/include/".str_replace("../", "", $_GET["include"]));
?>