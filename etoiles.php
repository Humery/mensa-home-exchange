<?php
// Génération d'un fichier png. Ne fonctionne que si GD2 est activé dans php.ini
header("Content-type: image/png");
$note=$_GET['note'];
$x=round($note*21)-1;
$etoiles=imagecreatefrompng('etoiles.png');
imagealphablending($etoiles,true);
//define size of $fond with list() and getimagesize ?
$fond=imagecreatetruecolor(106,21);
$jaune=imagecolorallocate($fond,255,255,64);
$blanc=imagecolorallocate($fond,255,255,255);
imageline($fond,$x,0,$x,20,$jaune);
imagefill($fond,0,0,$jaune);
imagefill($fond,105,0,$blanc);
imagecopymerge($fond,$etoiles,0,0,0,0,106,21,100);
//IE ne gère pas la transparence, alors le 'mauve' ne doit pas être laid
$mauve=imagecolorallocate($fond,254,254,255);
imagefill($fond,0,0,$mauve);
imagecolortransparent($fond,$mauve);
imagepng($fond,NULL,6);
?>