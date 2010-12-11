<?php
//	Bon, on a un petit problème: FPDF ne gère pas les GIF. Il faudrait reconvertir les GIF en PNG, mais ça serait compliqué. A moins de ne pas afficher les GIF, tout simplement. Pour l'instant, le solution consiste donc à éliminer les GIF avant affichage. Une astuce serait de convertir directement les GIF en PNG au moment de les charger. Il y aurait généralement une petite perte de profondeur, mais en général les images nuancées sont plûtot des JPEG, alors ça ne devrait pas poser de problèmes. Finalement, vu les problèmes de non-gestion du canal alpha, il vaudrait mieux restructurer les fichiers GIF et PNG/alpha à la volée, en espérant que ça ne prenne pas trop de temps.
//	Can a php script generate (using GET variables) then output a picture to another php script? I.e. can a php script call another, passing variables by GET?
session_start();
if (!$_SESSION['id']) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>M'Troc</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
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
include'connection.php';
define('FPDF_FONTPATH','./font/');
require('fpdf.php'); // Fichier de définition de l'objet 'pdf'
$Ref=$_GET['offre'];
$photos="./photos/".$Ref.".*";
$photos=glob($photos);
//	Elimination des images au format gif. A faire: les convertir en png, tant que le module adéquat est présent)
$photos2=array();
foreach($photos as$x)
	if (!stripos($x,".gif"))
		$photos2[]=$x;
$photos=$photos2;
unset($photos2);
//	Autres données de l'offre
$donnees=mysql_fetch_assoc(mysql_query("select ref,round(sum(note)/count(note),1) as moy,descri,prefixe,prenom,nom,contact,offres.pays as pays,region,adresse,type,couchages,dates,duree,annee,jardin,garage,voiture,tele,conint,mer,montagne,campagne,cville,banlieue,enfants,animaux,fumeurs from offres join utils on util=id left join comm_offres on ref=offre where ref=$Ref group by ref"));
//	Début de création du pdf
$offre=new FPDF();
$offre->SetDisplayMode('default','default');
$offre->SetFont('Times',"",12);
$offre->setTitle('M\'Troc offer '.$Ref);
$offre->setSubject('Détails for offer number '.$Ref);
$offre->setAuthor('Antoine Chassagnard');
$offre->setCreator('FPDF (www.fpdf.org)');
$offre->AddPage();
define('INTER',6);
define('N2',190);
$offre->SetLeftMargin(15);
$offre->SetRightMargin(15);
$offre->SetAutoPageBreak(true,10);
//	En-tête et numéro de l'offre
$offre->SetFont('','BU',18);
$infos="M'Troc - Home exchange offer number {$donnees['ref']}";
$offre->Cell(0,INTER*1.5,$infos,'','','C');
$offre->SetFont('','',12);
// Photos (s'il y en a)
switch(count($photos)) {
	case 0:
		$offre->SetXY(20,40);
		$offre->SetFont('','I');
		$offre->Cell(0,INTER,"(No available picture)",0,0,'C');
		$offre->SetFont('','');
		$offre->SetY(70);
		break;
	case 1:
		$offre->Image($photos[0],70,30,70,52.5);
		$offre->SetY(92.5);
		break;
	case 2:
		$offre->Image($photos[0],30,30,70,52.5);
		$offre->Image($photos[1],110,30,70,52.5);
		$offre->SetY(92.5);
		break;
	case 3:
		$offre->Image($photos[0],30,30,70,52.5);
		$offre->Image($photos[1],110,30,70,52.5);
		$offre->Image($photos[2],70,92.5,70,52.5);
		$offre->SetY(155);
		break;
	case 4:
	default:
		$offre->Image($photos[0],30,30,70,52.5);
		$offre->Image($photos[1],110,30,70,52.5);
		$offre->Image($photos[2],30,92.5,70,52.5);
		$offre->Image($photos[3],110,92.5,70,52.5);
		$offre->SetY(155);
		break; }
// Note sur 5 et étoiles
if($donnees['moy']!=NULL) {
	$x=$offre->GetX();
	$y=$offre->GetY();
	$offre->SetFillColor(255,255,64);
	//21.2 points par étoile, 72 ppp, 25.4 mm par pouce
	$largeur=$donnees['moy']*538.48/72;
	$offre->Rect($x,$y-2,$largeur,7.4,'F');
	$offre->Image("etoiles.png",$x,$y-2);
	$offre->SetX($x+43);
//	$infos="(Note moyenne: ".str_replace(".",",",$donnees['moy'])." / 5)";
	$infos="(Average score: ".$donnees['moy']." / 5)";
	$longueur=$offre->GetStringWidth($infos);
	$offre->Cell($longueur,INTER,$infos); }
$offre->Ln();
// Description du logement
$offre->SetFont('','B');
$offre->Cell(170,INTER,"Description:",'',1);
$offre->SetFont('','');
$offre->MultiCell(0,INTER,$donnees['descri'],'',1);
$offre->Ln(INTER);
if ($offre->GetY()>N2) { // Seulement s'il ne reste pas assez de place au recto.
	$offre->AddPage();
	$niv=10;
} else $niv=$offre->GetY();
// Données de l'offre et de l'offreur
function bloc($a,$b,$c,$d=5,$e=NULL) { // afficher un bout de texte en gras souligné suivi d'un bout de texte normal
// Pour ne pas avoir à passer $offre à chaque fois, il faudrait probablement définir une extension d'objet pour définir une nouvelle méthode. Ce n'est pas dit que ce soit plus simple.
	$c->SetFont('','BU');
	$c->SetX($c->GetX()+$d);
	$c->Write(INTER,$a);
	$c->SetFont('','');
	$c->Write(INTER," ");
	$longueur=$c->GetStringWidth($b."  "); // sans les espaces, trop court, bizarrement
	if ($e) $longueur=$e;
	$c->MultiCell($longueur,INTER,$b,'','L'); }
bloc("Offer by",'',$offre,0);
bloc("Name:",$donnees['prefixe']." ".$donnees['prenom']." ".$donnees['nom'],$offre);
bloc("Contact info:",'',$offre);
bloc("",$donnees['contact'],$offre);
bloc("Offer",'',$offre,0);
bloc("Country:",$donnees['pays'],$offre);
bloc("Area:",$donnees['region'],$offre);
bloc("Address",'',$offre);
bloc("",$donnees['adresse'],$offre);
bloc("Type:",$donnees['type'],$offre);
bloc("Number of places:",$donnees['couchages'],$offre);
bloc("Dates:",'',$offre);
bloc("",$donnees['dates'],$offre,'5',70);
$offre->SetXY(105,$niv);
$x="Garden:\nGarage:\nCar loan:\nTelevision:\nInternet:\nNear the sea:\nNear mountains:\nNear the countryside:\nIn the town center:\nIn the suburbs:\nChildren welcome:\nPets welcome:\nSmokers welcome:";
$offre->SetFont('','BU');
$x2=explode("\n",$x);
$longueur=0;
foreach($x2 as $y) {
	$z=$offre->GetStringWidth($y."   ");
	$longueur=$longueur<$z?$z:$longueur;}
$offre->MultiCell($longueur,INTER,$x,'','L');
$offre->SetFont('','');

foreach(array("jardin","garage","voiture","tele","conint","mer","montagne","campagne","cville","banlieue","enfants","animaux","fumeurs")as$x=>$y) {
	if ($donnees[$y]) {
		$offre->Image('vert.png',105+$longueur,($niv+1+$x*INTER),4);
		$offre->SetXY(109+$longueur,$niv+$x*INTER);
		$offre->Cell(3,INTER,"Yes");
	} else {
		$offre->Image('rouge.png',105+$longueur,$niv+1+$x*INTER,4);
		$offre->SetXY(109+$longueur,$niv+$x*INTER);
		$offre->Cell(3,INTER,"No"); } }

$offre->Output('MTroc'.$Ref.'.pdf','D');
// Reste à faire: les avertissements en cas de 'blème graphique (comme un canal alpha) et la conversion des gif en png.
} ?>