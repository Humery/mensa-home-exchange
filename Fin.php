<?php
session_start();
$_SESSION = array();
setcookie('PHPSESSID','',time()-1,'/');
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Mensa Home Exchange | Log out</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor / vi">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<body>
	<div class=centre><!img width=800 height=150 alt="Ici, encore un joli dessin" src="MTrocEnTete.jpeg">
	<p>You have logged out of your session.</p>
	<p><a href='index.php'>Return to the first page</a></p>
	</div>
</body>
</html>
