<?php
class  Page_login {
	function display() {
		if(isset($_SESSION["admin"])) {
			echo "<meta http-equiv=\"refresh\" content=\"0; URL=".Url::rewrite("page/admin/home")."\">";
		}
		echo "<h2>Hier kannst du dich mit den, bei der Registrierung angegebenen Nutzerdaten, einloggen.</h2>
		<div class=\"result\"></div><br />
		<fieldset><legend>Logindaten</legend>
		Nutzername: <input type=\"text\" id=\"user\"><br />
		Passwort: <input type=\"password\" id=\"pw\"><br />
		<button onclick=\"login()\" class=\"cssbutton\">anmelden</button>
		</fieldset>
		<i><small>Ab hier m&uuml;ssen Cookies und Javascript aktiviert sein.</small></i>";
	}

	function header() {
		echo "<meta name=\"robots\" content=\"noindex, nofollow\">";
		echo "<script type=\"text/javascript\">
			function login() {
				var user = document.getElementById('user').value;
				var pw = document.getElementById('pw').value;
				$.post(\"".Url::rewrite("include/login.php")."\", {
				    user: user,
				    pw: pw
				  },
				  function(data){
				    $('.result').html(data);
				  });
			}
		</script>";
	}
}
?>