<?php
session_start();
$prenom=($_POST['prenom']);
$prenom=($prenom!=""?$prenom:"(Non-précisé)");
$patro=($_POST['patro']);
$prefixe=($_POST['prefixe']);
$contact=($_POST['contact']);
$pays=($_POST['pays']);
$langue=($_POST['langue']);
$login=($_POST['login']);
$passe=$_POST['mdp1']; //d'accord, il y a aussi mdp2, mais en principe ça a déjà été confirmé comme étant identique
if (!($patro&&$prefixe&&$contact&&$pays&&$pays!="xx"&&$langue&&$langue!="xx"&&$login&&$passe))
	$succes=!($manquant=true);
else
	$manquant=false;
$id=@$_POST['iden'];
$redondant=false;
include 'connection.php';
if (!get_magic_quotes_gpc()) {
	$prenom=mysql_real_escape_string($prenom);
	$patro=mysql_real_escape_string($patro);
	$prefixe=mysql_real_escape_string($prefixe);
	$contact=mysql_real_escape_string($contact);
	$pays=mysql_real_escape_string($pays);
	$langue=mysql_real_escape_string($langue);
	$login=mysql_real_escape_string($login); }
$mdp=md5($passe);
if ($id) {
	$verification="select id from utils where (login='".$login."' or mdp=md5('".$passe."'))&&mdp!=md5('".$_SESSION['mdp']."')";
	$x=mysql_fetch_array(mysql_query($verification));
	if ($x) $redondant=true;
	//	alors problème, à règler en douceur: le login est déjà pris
	$insertion="update utils set login='".$login."',mdp='".$mdp."',prefixe='".$prefixe."',prenom='".$prenom."',nom='".$patro."',pays='".$pays."',langue='".$langue."',contact='".$contact."' where id=".$id;
} else {
	$verification="select id from utils where login='".$login."' or mdp=md5('".$passe."')";
	$verification=mysql_query($verification);
	$x=mysql_fetch_array($verification);
	if ($x) $redondant=true;
	//	alors problème, à règler en douceur: le login ou le mot de passe sont déjà pris
	$insertion="insert into utils values (NULL,'".$login."','".$mdp."','".$prefixe."','".$prenom."','".$patro."','".$pays."','".$langue."','".$contact."',DEFAULT,DEFAULT,DEFAULT,DEFAULT)"; }
if (!$redondant&&!$manquant) $succes=@mysql_query($insertion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Mensa Home Exchange website | account management</title>
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<body>
<?php
if ($redondant) {
	echo "	<div class=centre><img src=bigangry.gif></div><br>\n";
	echo "	<p>You must choose a different login and password: one or the other is already taken.</p>\n";
		if ($id)
			echo "	<div class=centre><a href='accueil.php'>Return to the main page</a></div>\n";
		else
			echo "	<div class=centre><a href='inscription.html'>Return to the account creation page</a></div>\n";
} elseif ($succes) {
	echo "	<div class=centre><img src=bigsmile.gif></div><br>\n";
	if ($id)
		echo "	<p>You have just updated your account information. The change was a success. To avoid trouble, please <a href='Fin.php'>log out</a> and log in to a new session. You can then continue using the site without awaiting confirmation from a moderator.</p>\n";
	else {
		echo "	<p>Congratulations $prefixe $patro, you have just subscribed to the <i>Mensa Home Exchange</i> service! A word of warning however: your account must be confirmed before you can use it. Don't hesitate to pester your national moderator (he accepted the job, after all! <img src=evilmini.gif>). Once your account has been confirmed, the whole MHE team wishes you luck in your Home Exchanges!</p>\n";
		echo "	<div class=centre><a href='index.php'>Return to the first page</a></div>\n";
//$modo= courriel du modo responsable
$modo=mysql_fetch_array(mysql_query("select courriel from utils right join modos on utils.id=modos.id where (utils.pays='$pays' && utils.modo>0) || utils.modo=2 order by utils.modo asc"));
//$modo="tacredips@gmail.com";
$message=wordwrap("<p>$prefixe $prenom $patro has created a Mensa Home Exchange account, and most probabably wants it confirmed.</p><p>Before doing so, don't forget to make sure $prenom $patro really is a current Mensa member.</p>",72);
$enplus="MIME-Version: 1.0\r\nContent-type:text/html;charset=\"UTF-8\"\r\n";
$enplus.="From:Otto Matique <robot@mhe.mensa.fr>\r\nReply-to:mhe@mensa.fr\r\n";
$enplus.="X-Mailer: PHP/".phpversion();
mail($modo['courriel'],"(Automatic message) New Mensa Home Exchange inscription",$message,$enplus);
}
		// En fait, ça serait pas plus mal de garder une liste rien que pour les petits chefs, laquelle se verrait automatiquement renseignée des nouvelles inscriptions.
} elseif ($manquant) {
// Cette section doit être complétée
	echo"	<div class=centre><img src=bigangry.gif></div><br>\n";
	if ($id)
		echo "	<p>A problem occured while updating your account: the following information was not received: </p>\n";
	else
		echo "	<p>The site encountered a problem. Your account was not created because the following information is missing:</p>\n";
	echo"	<div style='margin-left:30pt'>\n";
	if (!$patro||!$prefixe)
		echo"		<p>Your name.</p>\n";
	if (!$contact)
		echo"		<p>Your contact information.</p>\n";
	if ($pays=="xx")
		echo"		<p>Your national Mensa.</p>\n";
	if ($langue=="xx")
		echo"		<p>Your preferred language.</p>\n";
	if (!$login)
		echo"		<p>Your chosen login.</p>\n";
	if (!$passe)
		echo"		<p>Your password.</p>\n";
	echo"	</div>\n";
	echo "	<div class=centre><a href='inscription.php'>Return to the account creation page</a></div>\n";
} else {
	echo "	<div class=centre><img src=bigangry.gif></div><br>\n";
	if ($id) {
		echo "	<p>An unknown problem occurred during your account update (which probably failed). Please accept the team's apologies and warn your national moderator.</p>\n";
		echo "	<div class=centre><a href='accueil.php'>Return to the main page</a></div>\n";
	} else
		echo "	<p>An unknown problem occured and your account was not created. Please accept the team's apologies and warn your national moderator.</p>\n";
		echo "	<div class=centre><a href='index.php'>Return to the first page</a></div>\n"; }
?>
<!--
Chaque nouvelle inscription devrait envoyer aussi un message sur la liste des petits chefs (avec les détails utiles)
-->
</body>
</html>
