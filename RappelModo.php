<?php
include 'connection.php';
$x=get_magic_quotes_gpc();
$id=$x?$_GET['id']:mysql_real_escape_string($_GET['id']);
session_start();
$adresse=mysql_fetch_array(mysql_query('select courriel from modos where id=(select id from utils where ((modo>0 && pays=(select pays from utils where id="'.$id.'"))||modo=2) order by modo asc limit 1)'));
$pre=mysql_fetch_array(mysql_query('select prefixe from utils where id="'.$id.'"'));
$nom=mysql_fetch_array(mysql_query('select nom from utils where id="'.$id.'"'));
$qui=$pre['prefixe']." ".$nom['nom'];
mail($adresse,"MHE new subscriber: reminder",$qui." has created an account and would like you to attend to it!","From:Otto Matique <robot@mhe.mensa.fr>\r\nReply-to:mhe@mensa.fr\r\n");
?>
<head>
	<title>Mensa Home Exchange | Reminding your moderator</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor / vi">
	<meta name="lang" content="en-uk">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>
<body>
<p>An e-mail has been sent to your national moderator, with a reminder of your inscription.</p>
</body>
</html>
