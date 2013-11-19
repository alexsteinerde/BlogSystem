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
				<form action="install.php" method="post">
					Datenbank Host: <input type="text" name="host" value="localhost"><br>
					Benutzer: <input type="text" name="user" placeholder="Datenbank Benutzer"><br>
					Passwort: <input type="password" name="pw" placeholder="Datenbank Passwort"><br>
					Datenbank: <input type="text" name="db" placeholder="Datenbank"><br>
					Praefix: <input type="text" name="praefix" value="ab_"><br><br>
					<b>Zugangsdaten f&uumlr das Backend:</b><br>
					Username: <input type="text" name="username" placeholder="Username"><br>
					Passwort: <input type="password" name="userpw" placeholder="Passwort"><br><br>
					<b>Erste Einstellungen:</b><br>
					Seitentitel: <input type="text" name="titel" placeholder="Titel"><br>
					<input type="submit">
				</form>
			</div>
		</div>
	</body>
</html>