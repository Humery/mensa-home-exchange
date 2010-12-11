<?php
session_start();
// On part ici du principe que les informations ont été vérifiées une première fois sur la page précédente, grâce à une script. (C'est probablement une erreur.)
include 'connection.php';
if (!get_magic_quotes_gpc()) {}
$afaire=($_POST['tache']);
if ($afaire=='maj') { // il s'agit d'une mise à jour ||$afaire=="Mise à jour"
	if (!get_magic_quotes_gpc()) { // histoire de sécuriser les données
		$ref=mysql_real_escape_string(@$_POST['refoffre']);
		$util=mysql_real_escape_string($_SESSION['id']);
		$adresse=mysql_real_escape_string($_POST['lieu']);
		$typelog=mysql_real_escape_string($_POST['typelog']);
		$couchages=mysql_real_escape_string($_POST['lits']);
		$duree=@mysql_real_escape_string($_POST['duree']);
		$annee=@mysql_real_escape_string(($_POST['duree']==1)?$_POST['anneeD']:"0");
		$saison=mysql_real_escape_string(@$_POST['sp'].@$_POST['se'].@$_POST['sa'].@$_POST['sh']);
		$dates=mysql_real_escape_string($_POST['datesprecises']);
		$descri=mysql_real_escape_string($_POST['descri']);
	} else {
		$ref=@$_POST['refoffre'];
		$util=$_SESSION['id'];
		$adresse=$_POST['lieu'];
		$typelog=$_POST['typelog'];
		$couchages=$_POST['lits'];
		$duree=@$_POST['duree'];
		$annee=@($_POST['duree']==1)?$_POST['anneeD']:"0";
		$saison=@$_POST['sp'].@$_POST['se'].@$_POST['sa'].@$_POST['sh'];
		$dates=$_POST['datesprecises'];
		$descri=$_POST['descri']; }
	$jardin=@$_POST['jardin']?'TRUE':'FALSE';
	$garage=@$_POST['garage']?'TRUE':'FALSE';
	$voiture=@$_POST['voiture']?'TRUE':'FALSE';
	$tele=@$_POST['tele']?'TRUE':'FALSE';
	$conint=@$_POST['conint']?'TRUE':'FALSE';
	$mer=@$_POST['mer']?'TRUE':'FALSE';
	$montagne=@$_POST['montagne']?'TRUE':'FALSE';
	$campagne=@$_POST['campagne']?'TRUE':'FALSE';
	$cville=@$_POST['cville']?'TRUE':'FALSE';
	$banlieue=@$_POST['banlieue']?'TRUE':'FALSE';
	$enfants=@$_POST['enfants']?'TRUE':'FALSE';
	$animaux=@$_POST['animaux']?'TRUE':'FALSE';
	$fumeurs=@$_POST['fumeurs']?'TRUE':'FALSE';
	$insertion="update offres set adresse='".$adresse."',type='".$typelog."',couchages='".$couchages."',duree='".$duree."',annee='".$annee."',saisons='".$saison."',dates='".$dates."',descri='".$descri."',jardin=".$jardin.",garage=".$garage.",voiture=".$voiture.",tele=".$tele.",conint=".$conint.",mer=".$mer.",montagne=".$montagne.",campagne=".$campagne.",cville=".$cville.",banlieue=".$banlieue.",enfants=".$enfants.",animaux=".$animaux.",fumeurs=".$fumeurs." where ref=".$ref." and util=".$util;
//	Gestion des images
	for($x=1;$x<5;$x++) {
		$y=@$_FILES["photo".$x];
		if(@$y['size']>1&&@$y['size']<=200000) {
			if($vieux=glob("./photos/".$ref.".".$x.".*"))
				$deleteold=unlink($vieux[0]);
			$valide=true;
			switch($y['type']) { // le type MIME n'est pas garanti
				case"image/gif":
				case"image/jpeg":
				case"image/png":
					$fich=explode("/",$y['type']);
					$fich="./photos/".$ref.".".$x.".".$fich[1];
					break;
				case"image/pjpeg": // encore un machin bidon de chez IE
					$fich="./photos/".$ref.".".$x.".jpeg";
					break;
				case"image/x-png": // encore un machin bidon de chez IE
					$fich="./photos/".$ref.".".$x.".png";
					break;
				default:
					$valide=false; }
			if($valide)
				$moveupload=move_uploaded_file($y['tmp_name'],$fich);
				chmod($fich,0646); } }
//	Gestion des données manquantes
	if ($ref===""||$util===""||$adresse===""||$duree===""||$annee===""||$saison===""||$dates===""||$typelog===""||$typelog=='aucun'||$couchages===""||$couchages=='aucun'||$descri==="")
		$manquant=!$succes=false;
	else
		$manquant=false;
} elseif ($afaire=='effacer'||$afaire=="Effacer cette offre") {
	$ref=$_POST['refoffre'];
//	$insertion="delete from offres where ref=".$ref;
//	$insertion="delete from comm_offres where offre=".$ref;
	$insertion="select id from utils order by id limit 1";
	if ($ref==="")
		$manquant=!$succes=false;
	else
		$manquant=false; // 5 lignes, simple histoire de régulariser
//	Effacement réel, ou désactivation? Problème de référence libérée puis réutilisée, héritant ainsi des commentaires d'une autre offre.
// En cas de réel effacement, mysql_query("optimize table offres"); tout de suite après
} elseif ($afaire=='nouvelle'||$afaire=="Soumettre l'offre") { // c'est une nouvelle offre
//	($afaire=="Soumettre l'offre") pas normal, mais rend compatible avec IE
	if (!get_magic_quotes_gpc()) {
		$util=mysql_real_escape_string($_SESSION['id']);
		@list($pays,$region)=explode("§",mysql_real_escape_string($_POST['endroitO']));
		$adresse=mysql_real_escape_string($_POST['lieu']);
		$duree=@mysql_real_escape_string($_POST['duree']);
		$annee=@mysql_real_escape_string(($_POST['duree']==1)?$_POST['anneeD']:"0");
		$saison=mysql_real_escape_string(@$_POST['sp'].@$_POST['se'].@$_POST['sa'].@$_POST['sh']);
		// A récupérer avec (strpos($saison,"X")===true)
		$dates=mysql_real_escape_string($_POST['datesprecisesO']);
		$typelog=mysql_real_escape_string($_POST['typelog']);
		$couchages=mysql_real_escape_string($_POST['lits']);
		$descri=mysql_real_escape_string($_POST['descri']);
	} else {
		$util=$_SESSION['id'];
		@list($pays,$region)=explode("§",$_POST['endroitO']);
		$adresse=$_POST['lieu'];
		$duree=@$_POST['duree'];
		$annee=@($_POST['duree']==1)?$_POST['anneeD']:"0";
		$saison=@$_POST['sp'].@$_POST['se'].@$_POST['sa'].@$_POST['sh'];
		// A récupérer avec (strpos($saison,"X")===true)
		$dates=$_POST['datesprecisesO'];
		$typelog=$_POST['typelog'];
		$couchages=$_POST['lits'];
		$descri=$_POST['descri']; }
	$jardin=@$_POST['jardin']?'TRUE':'FALSE';
	$garage=@$_POST['garage']?'TRUE':'FALSE';
	$voiture=@$_POST['voiture']?'TRUE':'FALSE';
	$tele=@$_POST['tele']?'TRUE':'FALSE';
	$conint=@$_POST['conint']?'TRUE':'FALSE';
	$mer=@$_POST['mer']?'TRUE':'FALSE';
	$montagne=@$_POST['montagne']?'TRUE':'FALSE';
	$campagne=@$_POST['campagne']?'TRUE':'FALSE';
	$cville=@$_POST['cville']?'TRUE':'FALSE';
	$banlieue=@$_POST['banlieue']?'TRUE':'FALSE';
	$enfants=@$_POST['enfants']?'TRUE':'FALSE';
	$animaux=@$_POST['animaux']?'TRUE':'FALSE';
	$fumeurs=@$_POST['fumeurs']?'TRUE':'FALSE';
	$insertion="insert into offres values (NULL,'".$util."','".$pays."','".$region."','".$adresse."','".$typelog."','".$couchages."','".$duree."','".$annee."','".$saison."','".$dates."','".$descri."',".$jardin.",".$garage.",".$voiture.",".$tele.",".$conint.",".$mer.",".$montagne.",".$campagne.",".$cville.",".$banlieue.",".$enfants.",".$animaux.",".$fumeurs.",DEFAULT)";
//	Section gestion des images
	$ref=mysql_fetch_array(mysql_query("select ref from offres order by ref desc limit 1"));
	$ref=$ref['ref']+1;
	foreach($_FILES as$x=>$y) {
		if($y['size']>1&&$y['size']<=200000)
		switch($y['type']) { // le type MIME n'est pas garanti
			case"image/gif":
			case"image/jpeg":
			case"image/png":
				$fich=explode("/",$y['type']);
				$fich="./photos/".$ref.".".ltrim($x,"phot").".".$fich[1];
				break;
			case"image/pjpeg": // encore un machin bidon de chez IE
				$fich="./photos/".$ref.".".ltrim($x,"phot").".jpeg";
				break;
			case"image/x-png": // encore un machin bidon de chez IE
				$fich="./photos/".$ref.".".ltrim($x,"phot").".png";
				break; }
		@move_uploaded_file($y['tmp_name'],$fich);
		@chmod($fich,0746); }
	if ($util===""&&$pays===""&&$region===""&&$duree===""&&$annee===""&&$saison===""&&$dates===""&&$typelog===""&&$typelog=='aucun'&&$couchages===""&&$couchages=='aucun'&&$descri==="")
		$manquant=!$succes=false;
	else
		$manquant=false; }
// Save pictures as a VARBINARY or BLOB database entry?
// Alerte en cas d'échec?
// Several entries could be the ENUM type (one of a predefined set)
// The features (banlieue, animaux) could be a SET type (several of a predefined set)
if(!$manquant) $succes=mysql_query($insertion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>M's Troc | offer management</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<body>
<?php /*
foreach($_POST as$x=>$y)
echo"<p>$x= $y</p>\n";
foreach($_FILES as$w=>$x){
echo"<p>$w= $x</p>\n";
foreach($x as$y=>$z)
echo"<p>$y= $z</p>\n";}
echo"MySQL=$insertion\n";
echo"<p>replaced file= $vieux[0]</p>\n";
echo"<p>old photo deleted= $deleteold</p>\n";
echo"<p>uploaded file= $fich</p>\n";
echo"<p>new photo moved/renamed= $moveupload</p>\n"; */
if ($succes)
	switch ($afaire) {
	case 'nouvelle':
	case "Soumettre l'offre":
		echo "	<div class=centre><img src=bigsmile.gif></div>\n";
		echo "	<p>Your offer was successfully recorded. Congratulations from the M'Troc team and good luck in your Home Exchanges.</p>\n";
		break;
	case 'maj':
		echo "	<div class=centre><img src=bigsmile.gif></div>\n";
		echo "	<p>The update was successful. Congratulations from the M'Troc team and good luck in your Home Exchanges.</p>\n";
		if(isset($deleteold))
			echo"	<p>(Refresh the main page if your picture doesn't appear straight away.)</p>\n";
		break;
	case 'effacer':

		break; }
elseif (@$manquant) {
	switch ($afaire) {
	case 'nouvelle':
	case "Soumettre l'offre":
		echo "	<div class=centre><img src=bigangry.gif></div>\n";
		echo "	<p>Your offer wasn't recorded because the following information was missing:</p>\n";
		break;
	case 'maj':
		echo "	<div class=centre><img src=bigangry.gif></div>\n";
		echo "	<p>Your offer wasn't updated because the site didn't receive the following information:</p>\n";
		break;
	case 'effacer':
		echo"	<p class=antoine>There is a slight delay on the subject of deleting offers. It isn't a technical problem (that would have been easy), instead it's a question of whether or not to preserve data. Meanwhile, your offer was <b>not</b> deleted. In any case, the following information didn't reach the site:</p>\n";
		break; }
	echo"	<div style='margin-left:30pt'>\n";
//	echo"<p>\$ref=$ref, \$util=$util, \$adresse=$adresse, \$duree=$duree, \$annee=$annee, \$saison=$saison, \$dates=$dates, \$typelog=$typelog, \$couchages=$couchages, \$descri=$descri</p>\n";
	if ($util==="")
		echo"		<p>Your M'Troc account number.</p>\n";
	if ($pays===""||$region===""||$adresse==="")
		echo"		<p>The address for your home exchange offer.</p>\n";
	if ($duree===""||$annee===""||$saison===""||$dates==="")
		echo"		<p>The dates for your home exchange offer.</p>\n";
	if (!$typelog||$typelog=="aucun"||!$descri)
		echo"		<p>The description for your home exchange offer.</p>\n";
	if (!$couchages||$couchages=="aucun")
		echo"		<p>The number of available places.</p>\n";
	echo"	</div>\n";
} else
	switch ($afaire) {
	case 'nouvelle':
	case "Soumettre l'offre":
		echo "	<div class=centre><img src=bigangry.gif></div>\n";
		echo "	<p>An unknown problem occurred and your offer was not created. Please accept the team's apologies and warn your national moderator.</p>\n";
//	echo "	<p>ErrorCode= ".mysql_error()."\n</p>";
		break;
	case 'maj':
		echo "	<div class=centre><img src=bigangry.gif></div>\n";
		echo "	<p>An unknown problem occurred during your offer update (which probably failed). Please accept the team's apologies and warn your national moderator.</p>\n";
//	echo "	<p>ErrorCode= ".mysql_error()."\n</p>";
//	echo "	<p>query= $insertion</p>\n";
		break;
	case 'effacer':
		echo"	<p class=antoine>There is a slight delay on the subject of deleting offers. It isn't a technical problem (that would have been easy), instead it's a question of whether or not to preserve data. Meanwhile, your offer was <b>not</b> deleted.</p>\n";
		break; }
?>
	<div class=centre><a href='accueil.php'>Return to the main page</a></div>
</body>
</html>