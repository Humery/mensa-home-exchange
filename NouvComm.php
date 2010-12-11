<?php
// champs passés: RefOffre, id (par SESSION), comm (le message lui-même), score
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Mensa Home Exchange | Leave a comment</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<?php
//sécurité: session valide
if (!$_SESSION['id']) {
?>
<body>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
</body>
</html>
<?php } else {
include 'connection.php';
$x=get_magic_quotes_gpc();
$ref=($x?$_POST['RefOffre']:mysql_real_escape_string($_POST['RefOffre']));
$moment=date("Y-n-j H:i:s");
$message=($x?$_POST['comm']:mysql_real_escape_string($_POST['comm']));
if (@$_POST['score']!="")
	$score=@($x?$_POST['score']:mysql_real_escape_string($_POST['score']));
if (@$score=="")
//not sure about this...
	$score="NULL";
$instruction="insert into comm_offres values (".$ref.",".$_SESSION['id'].",'".$moment."','".$message."',".$score.",true)";
$succes=mysql_query($instruction);
//Also, still need a message moderation option somewhere.
if($succes) {
	echo "<body onLoad='self.document.location=\"VoirOffre.php?Ref=$ref\";'>\n";
?>
	<div class=centre><img src=bigsmile.gif></div><br>
	<p>Your comment was successfully recorded.</p>
	<p>Normally, you shouldn't have time to see this message&hellip;</p>
	<p>If you are not immediately returned to the offer's description, you can return manually <a href='VoirOffre.php?Ref=<?php echo$ref?>'>by clicking here</a>.</p>
<?php } else { ?>
<body>
	<div class=centre><img src=bigangry.gif></div><br>
	<p>A problem occurred and the site probably didn't record your comment. Please accept the team's apologies and warn your national moderator.</p>
	<div class=centre><a href='VoirOffre.php?Ref=<?php echo$ref?>'>Return to the offer's description</a></div>
</body>
</html>
<?php }} ?>
