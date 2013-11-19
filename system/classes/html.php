<?php
/**
* @author Alex Steiner
* @copyright Alex Steiner
* @link http://alexsteiner.de
*/
class HTML {
	static function greenBox($text)
	{
		echo "<div class='green'>$text</div>";
	}

	static function redBox($text)
	{
		echo "<div class='red'>$text</div>";
	}
}
?>