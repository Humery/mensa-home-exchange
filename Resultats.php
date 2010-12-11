<?php
// champs passés: endroitR, datedispo, nbplaces, jardin, garage, voiture, tele, conint, mer, montagne, campagne, cville, banlieue, enfants, animaux, fumeurs, refspec, id (par SESSION)
/*
Il y a ici un gros problème: cette page, une fois appellée par une méthode POST, semble se rappeller elle-même par une méthode GET (et je n'y comprends rien). Ceci pollue le fichier error_log et, plus grave, perd parfois la session en cours de route.
Pour la note moyenne, mysql_query("select note from comm_offres where ref=$refspec") puis redresser la ressource en liste puis $moy=isset($notes)?(array_sum($notes)/count($notes)):FALSE
*/
session_start();
$util=$_SESSION['id'];
$refspec=@$_POST['refspec'];
if (@$_POST['endroitR'])
@list($pays,$region)=explode("§",$_POST['endroitR']);
$datedispo=@($_POST['datedispo']?"&&saisons regexp '[".$_POST['datedispo']."]'":"");
$nbplaces=@($_POST['nbplaces']?$_POST['nbplaces']:"1");
// il faut sécuriser des données;
foreach (array("jardin","garage","voiture","tele","conint","mer","montagne","campagne","cville","banlieue","enfants","animaux","fumeurs") as $x) {
switch (@$_POST[$x]) {
	case 'oui':
		$$x='&&'.$x.'=true';
		break;
	case 'non':
		$$x='&&'.$x.'=false';
		break;
	case '?':
		$$x='';
		break; } }
// Cette boucle remplace 130 lignes de code! (Oui, j'en suis assez fier.)
include 'connection.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>M'Troc | Search results</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>

<?php
//sécurité: session valide
if (!$util) {
?>
<body>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
</body>
</html>
<?php } else { ?>
<body>
	<div class=centre><img width=800 height=100 alt="M'Troc website" src="MTrocEnTete.jpeg"></div>
<?php
if ($refspec) { // Offre spécifique, demandée par son numéro de référence
	if ($CetteOffre=@mysql_fetch_assoc(mysql_query("select ref,offres.pays,region,dates,prefixe,nom,duree,annee,round(sum(note)/count(note),1) as moy from offres join utils on id=util left join comm_offres on ref=offre where ref=$refspec&&valide=true&&!(duree='1'&&annee<year(curdate())&&annee='0') group by ref"))) {
		$photo="./photos/".$CetteOffre['ref'].".1.*";
		$photo=glob($photo);
		$photo=$photo?"<img src=\"".$photo[0]."\" height=300 width=400>\n":"<p><i>(No picture)</i></p>\n";
?>
	<table !width=90% class=centre cellpadding=30><tr><td class=boite>
<?php echo"		$photo";?>
		<p><b>Country and area</b>: <?php echo$CetteOffre['pays'].", ".$CetteOffre['region']?></p>
<?php echo ($CetteOffre['duree']=='1')?"		<p style='color:red'><b>Year</b>: ".$CetteOffre['annee']."</p>\n":'';?>
		<p><b>Availability</b>: <?php echo$CetteOffre['dates']?></p>
		<p><b>Offer by</b>: <?php echo$CetteOffre['prefixe']." ".$CetteOffre['nom']?></p>
		<p><b>Reference number for this offer</b>: <?php echo$CetteOffre['ref']?></p>
<?php echo ($CetteOffre['moy']!=NULL)?"<p><b>Average score</b>: ".str_replace(".",",",$CetteOffre['moy'])." / 5</p>\n":"<p>(<i>This offer hasn't been marked yet.</i>)</p>\n"?>
<?php echo"		<a href='VoirOffre.php?Ref={$CetteOffre['ref']}' target='_blank'>See details</a>\n"?>
		<p class=petit><i>(opens a new window)</i></p>
	</td></tr></table>
<?php } else { ?>
	<table width=90% class=centre cellpadding=20><tr><td class=boite>
		<p>No offer fits this number.</p>
	</td></tr></table>
<?php } } else { // Ensemble d'offres demandées par critères
	$reponse=@mysql_query("select ref,util,dates,prefixe,nom,round(sum(note)/count(note),1) as moy from offres join utils on id=util left join comm_offres on ref=offre where (util!='$util'&&valide=true&&offres.pays='$pays'&&region='$region'$datedispo&&!(duree='1'&&annee<year(curdate()))&&couchages>='$nbplaces'$jardin$garage$voiture$tele$conint$mer$montagne$campagne$cville$banlieue$enfants$animaux$fumeurs) group by ref");
// Curiosité de langage: en cas d'affichage de la requête sur la page, le < et le > peuvent poser problème au lecteurs de code source html et xml. Ceci dit, il s'agit en fait de SQL et la requête fonctionne très bien.
echo "	<table class=centre cellpadding=30 cellspacing=20>";
for ($x=0;$CetteOffre=mysql_fetch_assoc($reponse);$x++) {
$photo="./photos/".$CetteOffre['ref']."*";
$photo=glob($photo);
$photo=$photo?"<img src=\"".$photo[0]."\" height=300 width=400>\n":"<p><i>(No picture)</i></p>\n";
	echo ($x%2)?"<td class=boite>\n":"<tr><td class=boite>\n";
	echo "		$photo";
	echo "		<p><b>Availability</b>: {$CetteOffre['dates']}</p>\n";
	echo "		<p><b>Offer by</b>: {$CetteOffre['prefixe']} {$CetteOffre['nom']}</p>\n";
	echo "		<p><b>Reference number for this offer</b>: {$CetteOffre['ref']}</p>\n";
	echo(@$CetteOffre['moy']!=NULL)?"<p><b>Average score</b>: ".str_replace(".",",",$CetteOffre['moy'])." / 5</p>\n":"<p>(<i>This offer hasn't been marked yet.</i>)</p>\n";
	echo "		<a href='VoirOffre.php?Ref={$CetteOffre['ref']}' target='_blank'>See details</a>\n";
	echo "		<p class=petit><i>(opens a new window)</i></p>\n";
	echo ($x%2)?"	</td></tr>":"	</td>"; }
if (!$x%2) echo "</tr>";
if (!$x) echo "	<tr><td class=boite>\n		<p>No offers fit your search parametres</p>\n	</td></tr>";
echo "</table>\n"; }
?>
	<div class=centre><a href='accueil.php'>Return to the main page</a></div>
</body>
</html>
<?php } ?>
