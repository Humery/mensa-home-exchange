<?php
//Inclure un bouton pour voir les commentaires sur l'offreur (pas non plus inclus dans le pdf).
session_start();
$util=$_SESSION['id'];
$RefOffre=$_GET['Ref'];
include 'connection.php';
include 'ladate.php';
function paragraphes($y,$x=0) {
// $y = message à mettre en forme. $x = nombre de tabulations (pour une source propre).
	$b="";
	for(;$x>0;$x-=1) {
		$b.="	"; }
	$a="</p>\n".$b."<p>";
	$message=str_replace(array("\r\n","\n","\r"),"§§",$y);
	$message=str_replace("§§",$a,$message);
	$message=str_replace("<p></p>","<p style='margin:-0.4em 0.4em'>&nbsp;</p>",$message);
	echo "$b<p>$message</p>\n"; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>M'Troc<?php if($util){echo" | Offer number $RefOffre";}?></title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
	<script type="text/javascript" !src="scripts.js">
	function montrercacher() {
		if (document.getElementById("VoirComm").value=="Show the other users' comments") {
			document.getElementById("TabComm").style.display="block";
			document.getElementById("VoirComm").value="Hide comments"
		} else {
			document.getElementById("TabComm").style.display="none";
			document.getElementById("VoirComm").value="Show the other users' comments" }}
	</script>
</head>

<body>
<?php if (!$util) { ?>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
<?php } else {
// Détails de l'offre et note moyenne
$offre=mysql_fetch_array(mysql_query("select ref,round(sum(note)/count(note),1) as moy,descri,prefixe,prenom,nom,contact,offres.pays as pays,region,adresse,type,couchages,dates,duree,annee,jardin,garage,voiture,tele,conint,mer,montagne,campagne,cville,banlieue,enfants,animaux,fumeurs from offres join utils on util=id left join comm_offres on ref=offre where ref='$RefOffre' group by ref"));
// Photos
$photos=glob("./photos/".$RefOffre.".*");
// Commentaires
$commentaires=mysql_query("select afficher,moment,prefixe,nom,note,message from comm_offres join utils on messager=id where offre=$RefOffre order by moment desc");
foreach($photos as $x=>$y)
	$photo[$x+1]="<img src=\"".$y."\" height=300 width=400>";
?>
	<div class=centre>
	<table class=centre><tr><td>
		<table !width=100% class=centre cellspacing=10><tr>
<?php
if(isset($photo)) {
	echo"			<td>{$photo[1]}</td>\n";
	if(count($photo)>1) {
		echo"			<td>{$photo[2]}</td>\n";
		if(count($photo)>2) {
			echo"		</tr><tr>\n";
			$x=(count($photo)==3)?" colspan=2":"";
			if(count($photo)>2) {
				echo"			<td$x>{$photo[3]}</td>\n";
				if(count($photo)>3)
					echo"			<td>{$photo[4]}</td>\n"; } } } }
?>
		</tr></table>
	</td></tr><tr><td class=gauche>
		<p><b>Reference number</b>: <?php echo$offre['ref']?></p>
<?php
$x=str_replace ("\r\n","<br>",$offre['descri']);
echo "		<p><b>Description</b>: $x</p>\n";
if(@$offre['moy']!=NULL) {
	if(function_exists("gd_info"))
// soit génération d'un png complet (si le module GD est activé)
		echo"		<p><img src='etoiles.php?note={$offre['moy']}'></p>\n";
	else {
// soit affichage d'un png par-dessus un gif (s'il ne l'est pas).
		$barre=round($offre['moy']*21);
		echo"		<p><img src='rating.gif' height=21 width=$barre><img src='etoiles.png' style='position:relative; left:-$barre'></p>\n";}
	echo"		<p>(<b>Average score</b>: ".str_replace(".",",",$offre['moy'])." / 5)</p>\n"; }
if (strstr($offre['contact'],'\n'))
	$cont='</p>			<p>'.ereg_replace("/\r\n|\r|\n/","&nbsp;</p>\n			<p>",$offre['contact']);
else
	$cont=$offre['contact'];
?>
		<table class='data' cellspacing=20 !width=660 width=100%><tr><td>
			<p><b><u>Offer by</u></b></p>
			<p><b>Name</b>: <?php echo$offre['prefixe']." ".$offre['prenom']." ".$offre['nom']?></p>
			<p><b>Contact information</b>: <?php echo$cont?></p>
			<p><b><u>Offer</u></b></p>
			<p><b>Country</b>: <?php echo$offre['pays']?></p>
			<p><b>Area</b>: <?php echo$offre['region']?></p>
			<p><b>Address</b>:</p>
<?php paragraphes($offre['adresse'],3)?>
			<p><b>Type</b>: <?php echo$offre['type']?></p>
			<p><b>Number of places</b>: <?php echo($offre['couchages']==11?'more than ten':$offre['couchages'])?></p>
			<p><b>Availability</b>:</p>
			<p><?php echo$offre['dates']?></p>
<?php if ($offre['duree']==1)
echo "			<p><b>Year</b>: {$offre['annee']}</p>\n";
$choix=array(1=>"<img src=vert.gif> Yes",0=>"<img src=rouge.gif> No");?>
		</td><td>
			<p><b>Garden</b>: <?php echo$choix[$offre['jardin']]?></p>
			<p><b>Garage</b>: <?php echo$choix[$offre['garage']]?></p>
			<p><b>Car loan</b>: <?php echo$choix[$offre['voiture']]?></p>
			<p><b>Television</b>: <?php echo$choix[$offre['tele']]?></p>
			<p><b>Internet</b>: <?php echo$choix[$offre['conint']]?></p>
			<hr style='margin-left:0;text-align:left' width=60%>
			<p><b>Near the sea</b>: <?php echo$choix[$offre['mer']]?></p>
			<p><b>Near mountains</b>: <?php echo$choix[$offre['montagne']]?></p>
			<p><b>Near the countryside</b>: <?php echo$choix[$offre['campagne']]?></p>
			<p><b>In the town centre</b>: <?php echo$choix[$offre['cville']]?></p>
			<p><b>In the suburbs</b>: <?php echo$choix[$offre['banlieue']]?></p>
			<hr style='margin-left:0;text-align:left' width=60%>
			<p><b>Children welcome</b>: <?php echo$choix[$offre['enfants']]?></p>
			<p><b>Pets welcome</b>: <?php echo$choix[$offre['animaux']]?></p>
			<p><b>Smokers welcome</b>: <?php echo$choix[$offre['fumeurs']]?></p>
		</td></tr></table>
	</td></tr><tr><td !class=boite>
		<p><a href='OffrePDF.php?offre=<?php echo$RefOffre?>'>Download .pdf version</a> of this offer (without the comments).</p>
		<input type=button value="Show the other users' comments" id='VoirComm' onClick='montrercacher()'>
		<div class=centre id='TabComm' style="display:none">
			<table cellpadding=15 cellspacing=10 width=90% class=centre><tr><td class=boitegauche>
<?php
$y=false;
while ($comm=mysql_fetch_assoc($commentaires)) {
	$y=true;
// If mod, all are alterable. If not, only poster can alter own post? Or not?
/* If own post {
	echo "				<table width=100%><tr><td>\n";
	echo "				<p style='text-indent:5ex'><i>Le ".date_en_clair(strtotime($comm['moment'])).", ".$comm['prefixe']." ".$comm['nom']." a écrit:</i></p>\n";
	echo "				</td><td style='text-align:right'>\n";
	echo "				<button type=button style='font-size:8pt' onClick='self.document.location=\"mod_comm.php?comm=".$RefOffre."\"'>Modifier mon commentaire</button>\n";
	echo "				</td></tr></table>\n";
} elseif mod account { */
	echo "				<table width=100%><tr><td>\n";
	echo "				<p style='text-indent:5ex'><i>On ".date_en_clair(strtotime($comm['moment'])).", ".$comm['prefixe']." ".$comm['nom']." wrote:</i></p>\n";
	echo "				</td><td style='text-align:right'>\n";
	echo "				<button type=button style='font-size:8pt' onClick='self.document.location=\"mod_comm.php?comm=".$RefOffre."\"'>Moderate this comment</button>\n";
	echo "				</td></tr></table>\n";
/* } else {
	echo "				<p style='text-indent:5ex'><i>Le ".date_en_clair(strtotime($comm['moment'])).", ".$comm['prefixe']." ".$comm['nom']." a écrit:</i></p>\n";
} */
	paragraphes($comm['message'],4);
	echo"				<p style='text-align:center;word-spacing:5ex'>* * *</p>\n";
	if ($comm['note']) echo "				<p>Individual mark: {$comm['note']} / 5</p>\n";
	echo "				<hr>\n"; }
if (!$y) echo "				<p>No comments yet.</p>\n";
?>
			</td></tr><tr><td class=boitegauche>
				<form method=post action='NouvComm.php'>
				<p>Have you tried this offer? Did you like it (or not)? Leave a comment!</p>
				<textarea id='comm' name='comm' rows=9 cols=80></textarea>
				<p>Mark (optional): 
					<label><input type=radio name=score value=0>0</label> 
					<label><input type=radio name=score value=1>1</label> 
					<label><input type=radio name=score value=2>2</label> 
					<label><input type=radio name=score value=3>3</label> 
					<label><input type=radio name=score value=4>4</label> 
					<label><input type=radio name=score value=5>5</label>
				</p>
				<input type=hidden name='RefOffre' value=<?php echo"$RefOffre"?>>
				<div class=centre><button type=submit>Send your message</button></div>
				</form>
			</td></tr></table>
		</div>
		<div><button type=button onClick='self.close()'>Close this window</button></div>
	</td></tr></table>
	</div>
<br><br>
<?php } ?>
</body>
</html>