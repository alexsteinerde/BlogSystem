<?php
error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<DOCTYOE html>
<html>
	<head>
		<title>Installation</title>
		<link rel="stylesheet" type="text/css" href="install/css/main.css">
	</head>
	<body>
		<div class="wrapper">
			<h2>Installation</h2>
			<div class="text">
<?php
//Variablen
function myHash($string)
{
	$string = base64_encode($string);
	$string = md5($string);
	$string = sha1($string);
	$string = md5($string);
	$string = base64_encode($string);
	return $string;
}

$host = $_POST["host"];
$user = $_POST["user"];
$pw = $_POST["pw"];
$db = $_POST["db"];
$praefix = $_POST["praefix"];
$time = time();

$username = $_POST["username"];
$userpw = myHash($_POST["userpw"]);

$title = $_POST["titel"];

$pagehost = sprintf('http://%s%s', $_SERVER['HTTP_HOST'], dirname($_SERVER['PHP_SELF']))."/";

//Datanbank
if(!mysql_connect($host, $user , $pw))
{
	echo "Verbindung zur Datenbank konnte nicht hergestellt werden!";
}
else if(!mysql_select_db("$db"))
{
	echo "Datenbank konnte nicht ausgewählt werden!";
}
else if($username == "" AND $userpw == "d41d8cd98f00b204e9800998ecf8427e" AND $titel == "")
{
	echo "Es sind nicht alle Felder ausgefüllt worden!";
}
else
{
	//Wenn alles richtig ist
echo "CMS wurde installiert";

function deltree($f) {
	if (is_dir($f)) {
 		foreach(glob($f.'/*') as $sf) {
   		 if (is_dir($sf) && !is_link($sf)) {
      		deltree($sf);
    		} else {
      			unlink($sf);
    		}
 		}
		}
	rmdir($f);
}

$handle = fopen ( "system/config/dbsettings.php", "w" );//Config erstellen
fwrite($handle,trim('<?php
$host = "'.$host.'";
$user = "'.$user.'";
$pw = "'.$pw.'";
$database = "'.$db.'";
$praefix = "'.$praefix.'";
?>'));
fclose($handle );

require("system/config/dbsettings.php");

$verbindung = mysql_connect($host, $user, $pw) 
or die("Verbindung zur Datenbank konnte nicht hergestellt werden"); 
mysql_select_db($database) or die ("Datenbank konnte nicht ausgewählt werden"); 

function praefix() {
		require("system/config/dbsettings.php");
		return $praefix;
}
function command($command) {
	$command = str_replace("{praefix}", praefix(), $command);
	$back = mysql_query($command);
	return $back;
}

include_once("install/sql.php");

deltree("install");
unlink("install.php");

header("Location:$pagehost");
}
?>
			</div>
		</div>
	</body>
</html>