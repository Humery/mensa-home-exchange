<?php
// En cas d'effacement réel de compte, il faut aussi effacer toutes les offres associées.
session_start();
if (!$_SESSION['id']) { ?>
<html>
<head>
	<title>M'Troc | session trouble</title>
	<meta name=author content="Antoine Chassagnard">
	<meta name=generator content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>
<body>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
</body>
</html>
<?php
} else {
$faire=$_POST['quefaire'];
$compte=$_POST['compte'];
$zozo=explode("§",$faire);
include 'connection.php';
if ($zozo[0]=='valide') {
	$instruction="update utils set valide=(!valide) where id='".$compte."'";
	mysql_query($instruction);
	$instruction="select prefixe,nom,valide from utils where id='".$compte."'";
	$x=mysql_fetch_array(mysql_query($instruction)); }
if ($zozo[0]=='niveau') {
	$instruction="update utils set modo=".$zozo[1]." where id='".$compte."'";
	mysql_query($instruction);
	$instruction="select prefixe,nom,modo from utils where id='".$compte."'";
	$x=mysql_fetch_array(mysql_query($instruction)); }
?>
<html>
<head>
	<title>M'Troc | Mod action</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<body>
	<h1>Moderators' screen</h1>
<?php
if ($zozo[0]=='valide') {
	echo "	<table class=centre cellpadding=20><tr><td class=boite>\n";
	$y=$x['valide']?'validated':'invalidated';
	echo "		<p>{$x['prefixe']}'s account {$x['nom']} has been $y.</p>\n";
	echo "	</td></tr></table>\n"; }
if ($zozo[0]=='niveau') {
	echo "	<table class=centre cellpadding=20><tr><td class=boite>\n";
	switch ($x['modo']) {
	case "0":
		$y='normal user';
		break;
	case "1":
		$y='national moderator';
		break;
	case "2":
		$y='head of SIG';
		break; }
	echo "		<p>{$x['prefixe']} {$x['nom']} is now a $y.</p>\n";
	echo "	</td></tr></table>\n"; }

?>
	<div class=centre><a href='accueil.php'>Return to the main page</a></div>
</body>
</html>
<?php } ?>