<?php 
$title = Pages::get(Settings::pageData())->title; 
$klasse = Pages::get(Settings::pageData())->class;
$page = new $klasse; 
echo "<!DOCTYPE html> 
<html> 
    <head> 
        ".Header::get()."
        <link rel=\"stylesheet\" href=\"".url::rewrite("system/css/main.css")."\"> 
        <link rel=\"stylesheet\" href=\"".url::rewrite("system/skins/admin/main.css")."\"> 
        <script src=\"".url::rewrite("system/WYSIWYG/ckeditor.js")."\"></script> 
        ".$page->header()."
    </head> 
    <body> 
        <div class=\"wrapper\"> 
            <div style=\"height: 40px; background-color: #343434; padding: 5px; border-radius: 10px;\"> 
                <b style=\"position: absolute; color: #ffffff; line-height: 40px; font-size: 22px;\">Administratorbereich</b> 
                <div align=\"right\" style=\"height: 35px; font-size: 22px; color: #ffffff; line-height: 1em;\"> 
                    <a href=\"".url::rewrite("page/admin/home?art=user_logout")."\" style=\"text-decoration: none; color: white;\"><b>Abmelden</b></a><br > 
                    <b style=\"font-size: 14px; margin-right: 10px;\">".Login::getId(Session::get("login"))->mail."</b> 
                </div> 
            </div> 
            <div class=\"menu\">"; 
                echo Menu::get("<li>", "</li>"); 
            echo "</div> 
            <div class=\"context\">"; 
                $page->display(); 
            echo "</div> 
        </div> 
    </body> 
</html>"; 
?>