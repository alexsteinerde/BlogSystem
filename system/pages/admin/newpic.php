<?php
class Page_admin_newpic {
  function display() {
    $art = $_GET["art"];
    $location = $_GET["location"];
    $data = str_replace("../", "", $_GET["data"]);

    if($art == "save")
    {
      Upload::safe($_FILES['datei'], "system/images/user/$location".$_FILES['datei']['name'], "gif|jpg|png|swf");
      HTML::greenBox("Das Bild wurde erfolgreich hochgeladen");      
    }

    if($art == "del" AND $data != "") {
      unlink("system/images/user/$data");
      HTML::greenBox("Das Bild wurde erfolgreich gelöscht!");
    }
    $template = new template;
    $template->load("pics");
     if ($handle = opendir('system/images/user/')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
              $schleife = $template->addLoopItem("PICS");
              $schleife = $template->assignLoopVar($schleife, "FILE_PATH", url::rewrite("system/images/user/$file"));
              $schleife = $template->assignLoopVar($schleife, "PIC_NAME", $file);
              $schleife = $template->assignLoopVar($schleife, "DEL_URL", Url::rewrite("page/admin/newpic?art=del&data=$file"));
              $template->getLoop($schleife);
            }
        }
        closedir($handle);
    }
    $template->output();
    if (count(scandir('system/images/user/')) < 3) {
      echo "<i>Es sind keine Bilder vorhanden</i>";
    }
  }

  function header() {

  }
}
?>