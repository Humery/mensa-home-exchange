<?php
include 'connection.php';
include 'ladate.php';
$x=get_magic_quotes_gpc();
session_start();
if (@$_POST['compte']or@$_POST['mdp']) { //première visite de la journée
	$_SESSION['compte']=@(!$x?mysql_real_escape_string($_POST['compte']):$_POST['compte']);
	$_SESSION['mdp']=@$_POST['mdp']; }
if (@$_SESSION['compte']or@$_SESSION['mdp']) { //visites légitimes
	$instruction="select * from utils where login='".$_SESSION['compte']."'&&mdp=md5('".$_SESSION['mdp']."')";
	$InfosCompte=@mysql_fetch_array(mysql_query($instruction),MYSQL_ASSOC);
	$_SESSION['id']=$InfosCompte['id'];
} else $intrusion=true;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Mensa Home Exchange | Main page</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor / vi">
	<meta name="lang" content="en-uk">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
<?php
// Gestion des erreurs.
if (@$intrusion==true) {
// Problème de gestion des sessions ou, plus grave, tentative d'effraction.
?>
</head>

<body>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
</body>
</html>
<?php
} elseif (!$_SESSION['id']) {
// Le compte n'existe pas: mauvais login ou mauvais mot de passe (ou les deux).
?>
</head>

<body>
	<div class=centre><img src=bigangry.gif></div>
	<p>This account is not recognised:</p>
	<ul>
	<li>Maybe you made a mistake entering the login or password (<a href='index.php'>return to the first page</a>).
	<li>Maybe you haven't got an account. You can <a href='inscription.php'>create one</a> if you are a current Mensa member.
	</ul>
<?php /*
echo "<p>".$_POST['compte']."</p>\n";
echo "<p>id=".$_SESSION['id']." &rarr; query=".$instruction." &rarr; retrieved id=".$InfosCompte['id'].", session=".session_id()."</p>\n";
*/ ?>
</body>
</html>
<?php } elseif (!$InfosCompte['valide']) {
// Le compte n'a pas été validé par le modo.
?>
</head>

<body>
	<div class=centre><img width=800 height=100 alt="Mensa Home Exchange website" src="MTrocEnTete.jpeg"></div>
	<p>Your account hasn't been validated by a moderator. If this situation lasts (say, more than a week), don't hesitate to <a href="RappelModo.php?id=<?php echo $_POST['compte']?>">draw your national moderator's attention</a>!</p>
</body>
</html>
<?php } else {
// Fin de gestion des erreurs d'inscription.
if (!isset($_SESSION['dc'])) $_SESSION['dc']=$InfosCompte['date_connexion'];
$instruction="update utils set date_connexion=current_timestamp where id='".$_SESSION['id']."'";
mysql_query($instruction);
?>
	<script language="javascript" src="scripts.js">
	</script>
</head>

<body>
	<div class=centre><!img width=800 height=100 alt="Mensa Home Exchange website" src="MTrocEnTete.jpeg" /></div>
	<br>
	<!--
	Affichage par blocs, montrés ou cachés en fonction des boutons.
	-->
	<p>Welcome, <?php echo$InfosCompte['prefixe']." ".$InfosCompte['nom']?>.</p>
	<p>Your last connection was on <?php echo date_en_clair(strtotime($_SESSION['dc']))?>.</p>
<!--	<p>You have XX new messages.</p>-->
<!--
Messages perso: peuvent éventuellement servir aux membres pour se contacter.
Finalement, l'idée ne semble pas intéresser grand'monde.
-->
	<p>Would you like to:</p>
	<div class=centre>
	<button type=button onClick='montrer("recherche");'>search for an offer</button>
	<button type=button onClick='montrer("offres");'>manage your offers</button>
	<button type=button onClick='montrer("compte");'>manage your account</button>
<?php if ($InfosCompte['modo']>0) { ?>
	<button type=button onClick='montrer("modo");' class=danger><b>mod board</b></button>
<!--	<button type=button class=danger onClick='montrer("forum");'><b>forum modos (?)</b></button>-->
<!--
Messages non-nominatifs pour modos, aussi options de modération proprement dites (altérer/effacer un message, remonter la piste, trouver tous les messages par tel ou tel compte...). Modos1 -> seul leur pays et messages automatiques d'adhésion-validation, modos2 -> tous les messages (et effacement) et adhésion-validation pour pays sans modos.
Ou pas.
-->
<?php } ?>
	<button type=button class=bidule onClick="self.location.href='FAQ-en.php';">help me!</button>
	<button type=button class=bidule onClick="self.location.href='Fin.php';">log out</button>
	</div>
	<div style='display:none' id='recherche' class=centre>
	<!--
	Premier bloc.
	-->
		<form action="Resultats.php" method=post onSubmit='return verifR();' name=recherche_offres>
		<input type=hidden name=util value=<?php echo$_SESSION['id']?>>
		<table class=centre border cellpadding=15><tr><td>
		<div class=gauche>
			<p>When you run a search, <b>the only required parameter is the region</b>: all others are optional and are by default unspecified.</p>
			<p>If you have noticed a <b>specific offer</b> and remember it's <b>number</b>, you can instead recall it directly (this is also useful if you want to see what your offer looks like to others).</p>
		</div>
		<table cellpadding=20 cellspacing=30 class=centre>
		<tr><td class=boite>
			<table><tr><td>
				<p><label for=endroitR>Approximate region:</label></p>
			</td><td>
				<select name=endroitR ID=endroitR>
				<option selected value='aucune'>Choose a region</option>
<?php
//				N'afficher que les régions et pays disponibles.
				$x=mysql_query("select distinct offres.pays,region from offres join utils on (id=util) where (util!='".$_SESSION['id']."'&&valide=true&&!(duree='1'&&annee<year(curdate()))) order by pays,region");
				$endroit=mysql_fetch_array($x,MYSQL_ASSOC);
				while($endroit) {
					echo "				<optgroup label=\"".($pays=$endroit['pays'])."\">\n";
					while($pays==$endroit['pays']) {
						echo "					<option value=\"".$endroit['pays']."§".$endroit['region']."\">".$endroit['region']."</option>\n";
						$endroit=mysql_fetch_array($x,MYSQL_ASSOC); }
					echo "				</optgroup>\n"; }
// Inclure les pays en tant que choix valable? Vaste, mais faisable. Peut-être avec un code du genre 'return confirm("Vous avez choisi *pays* pour votre recherche.\rNous vous conseillons plûtot de choisir une région.\rEtes-vous sûr de votre choix?");'
?>
				</select>
			</td></tr><tr><td colspan=2>
				<hr width=65%>
			</td></tr><tr><td>
				<p>Approximate availability time:</p>
			</td><td>
				<table width=100% style='text-align:left'>
				<tr><td>
					<label><input type=radio value='1' name=datedispo>Spring</input></label>
				</td><td>
					<label><input type=radio value='2' name=datedispo>Summer</input></label>
				</td></tr><tr><td>
					<label><input type=radio value='3' name=datedispo>Autumn</input></label>
				</td><td>
					<label><input type=radio value='4' name=datedispo>Winter</input></label>
				</td></tr>
				</table>
			</td></tr><tr><td colspan=2>
				<hr width=65%>
			</td></tr><tr><td>
				<p>Number of places:</p>
			</td><td class=gauche>
				<p><label><input name=nbplaces type=radio value='1'>One</input></label></p>
				<p><label><input name=nbplaces type=radio value='2'>Two</input></label></p>
				<p><label><input name=nbplaces type=radio value='3'>Three to five</input></label></p>
				<p><label><input name=nbplaces type=radio value='6'>Six to ten</input></label></p>
				<p><label><input name=nbplaces type=radio value='11'>Over ten</input></label></p>
				</td></tr>
			</table>
		</td><td rowspan=2 class=boite>
			<div class=gauche>
			<p>Extra details:</p>
			<p>(Yes/No/No preference)</p>
			<p><input type=radio name=jardin value="oui">
			<input type=radio name=jardin value="non">
			<input type=radio name=jardin value="?" checked> with a garden</p>
			<p><input type=radio name=garage value="oui">
			<input type=radio name=garage value="non">
			<input type=radio name=garage value="?" checked> with a garage</p>
			<p><input type=radio name=voiture value="oui">
			<input type=radio name=voiture value="non">
			<input type=radio name=voiture value="?" checked> with a car loan</p>
			<p><input type=radio name=tele value="oui">
			<input type=radio name=tele value="non">
			<input type=radio name=tele value="?" checked> with television</p>
			<p><input type=radio name=conint value="oui">
			<input type=radio name=conint value="non">
			<input type=radio name=conint value="?" checked> with internet</p>
			<hr>
			<p><input type=radio name=mer value="oui">
			<input type=radio name=mer value="non">
			<input type=radio name=mer value="?" checked> near the sea</p>
			<p><input type=radio name=montagne value="oui">
			<input type=radio name=montagne value="non">
			<input type=radio name=montagne value="?" checked> near mountains</p>
			<p><input type=radio name=campagne value="oui">
			<input type=radio name=campagne value="non">
			<input type=radio name=campagne value="?" checked> near the countryside</p>
			<p><input type=radio name=cville value="oui">
			<input type=radio name=cville value="non">
			<input type=radio name=cville value="?" checked> in the town centre</p>
			<p><input type=radio name=banlieue value="oui">
			<input type=radio name=banlieue value="non">
			<input type=radio name=banlieue value="?" checked> in the suburbs</p>
			<hr>
			<p><input type=radio name=enfants value="oui">
			<input type=radio name=enfants value="non">
			<input type=radio name=enfants value="?" checked> children welcome</p>
			<p><input type=radio name=animaux value="oui">
			<input type=radio name=animaux value="non">
			<input type=radio name=animaux value="?" checked> pets welcome</p>
			<p><input type=radio name=fumeurs value="oui">
			<input type=radio name=fumeurs value="non">
			<input type=radio name=fumeurs value="?" checked> smokers welcome</p>
			</div>
		</td></tr><tr><td class=boite>
			<p><label>If you would like to find an offer for which you already know the number,<br>you can enter it here: <input size=5 maxlength=5 id=refR name=refspec></label></p>
			<p class=petit>(All other parameters are then ignored)</p>
			</td></tr>
		</table>
		<button type=submit>Submit &rarr;</button>
		</td></tr></table>
		</form>
	</div>
	<!--
	Fin du premier bloc.
	-->
	<div style='display:none' id="offres" class=centre>
	<!--
	Deuxième bloc
	-->
		<table class=centre border cellpadding=15>
		<tr><td>
		<p><em>Remember to check with your insurance before lending your house.</em></p>
		<div class=centre><button type=button onClick="montrer('CreerOffre');">Post an offer</button>
<?php
		$instruction="select * from offres where util=".$_SESSION['id'];
		$InfosOffres=mysql_query($instruction);
		$instruction="select ref,region from offres where util=".$_SESSION['id'];
		$RefOffres=mysql_query($instruction);
		$x=mysql_fetch_array($RefOffres,MYSQL_ASSOC);
		if ($x) {
		echo "		<select id=QuelleOffre onChange=\"montrer(document.getElementById('QuelleOffre').value);document.getElementById('premierchoix').selected=true;\">\n";
// Choisir 'premierchoix' provoque un (petit) bug; choisir une autre offre l'affiche puis remet immédiatement sur 'premierchoix', lequel ne peut donc pas (en théorie, et jusqu'à preuve du contraire), être choisi.
		echo "		<option selected id=premierchoix>Change an offer</option>\n";
		for (;$x;$x=mysql_fetch_array($RefOffres,MYSQL_ASSOC))
		echo "		<option value=indiv{$x['ref']}>Référence \"{$x['ref']}\", {$x['region']}</option>\n";
		echo "		</select>\n"; }
?>
<!-- début de formulaire de création d'une offre -->
		<div id=CreerOffre style='display:none'>
			<form action=majOffres.php method=post onSubmit='return verifO();' name=creation_offre enctype="multipart/form-data">
			<table class=centre cellpadding=20 !border cellspacing=30>
			<tr><td class=boite>
				<p><label for=endroitO>Country and area:</label></p>
				<select name=endroitO ID=endroitO>
				<option selected value="aucun">Area</option>
<?php
foreach (glob("MTROCpays.*.ini") as $fichierpays) {
	$nomdupays=explode(".",$fichierpays);
	$nomdupays=($nomdupays[1]);
	echo "				<optgroup label=\"$nomdupays\">\n";
	foreach (file($fichierpays, FILE_IGNORE_NEW_LINES) as $rpays) {
		echo "				<option value=\"$nomdupays"."§"."$rpays\">$rpays</option>\n"; }
	echo "				</optgroup>\n"; }
?>
				</select>
				<hr>
				<p><label for=lieu>Address:</label></p>
				<textarea id=lieu name=lieu rows=4 cols=30></textarea>
			</td><td class=boite rowspan=2>
				<table><tr><td>
				<p>This offer is valid:</p>
				</td><td class=gauche>
				<p><label><input type=radio name=duree id=duree1 value='1' onClick='document.getElementById("anneeD").disabled=false;document.getElementById("anneeD").focus()'> only once &rarr;</label></p>
				<p><label><input type=radio name=duree id=duree2 value='+' onClick='document.getElementById("anneeD").disabled=true;'> every year</label></p>
				</td><td>
				<p><label for=anneeD>Which year?</label></p>
				<p><input name=anneeD id=anneeD disabled size=4 maxlength=4></p>
				</td></tr></table>
				<hr>
				<table><tr><td>
				<p>This offer is for:</p>
				</td><td class=gauche>
				<p><label><input type=checkbox name=sp id=sp value=1>Spring</label></p>
				<p><label><input type=checkbox name=se id=se value=2>Summer</label></p>
				<p><label><input type=checkbox name=sa id=sa value=3>Autumn</label></p>
				<p><label><input type=checkbox name=sh id=sh value=4>Winter</label></p>
				<!-- A récupérer avec une PCRE. Ou une variable ENUM -->
				</td></tr></table>
				<hr>
				<p><label for=datesprecisesO>Dates:<label></p>
				<textarea rows=2 cols=30 name=datesprecisesO id=datesprecisesO></textarea>
			</td></tr><tr><td rowspan=2 class=boite>
				<div class=gauche>
				<p><label><input type=checkbox name=jardin>Garden</label></p>
				<p><label><input type=checkbox name=garage>Garage</label></p>
				<p><label><input type=checkbox name=voiture>Car loan</label></p>
				<p><label><input type=checkbox name=tele>Television</label></p>
				<p><label><input type=checkbox name=conint>Internet</label></p>
				<hr>
				<p><label><input type=checkbox name=mer>Near the sea</label></p>
				<p><label><input type=checkbox name=montagne>Near mountains</label></p>
				<p><label><input type=checkbox name=campagne>Near the countryside</label></p>
				<p><label><input type=checkbox name=cville>In the town centre</label></p>
				<p><label><input type=checkbox name=banlieue>In the suburbs</label></p>
				<hr>
				<p><label><input type=checkbox name=enfants>Children welcome</label></p>
				<p><label><input type=checkbox name=animaux>Pets welcome</label></p>
				<p><label><input type=checkbox name=fumeurs>Smokers welcome</label></p>
				</div>
			</td></tr><tr><td class=boite>
				<p><label for=typelog>Type of lodging:</label></p>
				<select name=typelog id=typelog>
				<option value="aucun">Choose one</option>
				<option value=appartement>Appartment</option>
				<option value=chalet>Chalet</option>
				<option value=chaumiere>Cottage</option>
				<option value=loft>Loft</option>
				<option value=manoir>Mansion</option>
				<option value=autre>Other</option>
				</select>
				<hr>
				<p><label for=lits>Number of places:</label></p>
				<select name=lits id=lits>
				<option value="aucun">Choose one</option>
				<option value=1>One</option>
				<option value=2>Two</option>
				<option value=3>Three</option>
				<option value=4>Four</option>
				<option value=5>Five</option>
				<option value=6>Six</option>
				<option value=7>Seven</option>
				<option value=8>Eight</option>
				<option value=9>Nine</option>
				<option value=10>Ten</option>
				<option value=11>Over ten</option>
				</select>
				<hr>
				<p><label for=descri>Description:</label></p>
				<textarea rows=6 cols=50 id=descri name=descri></textarea>
			</td></tr><tr><td colspan=2 class=boite>
				<button type=button onClick='photoguide();'>&rarr; Instructions for the pictures &larr;</button>
				<input type=hidden name="MAX_FILE_SIZE" value="200000">
				<table !width=100% class=centre><tr><td>
					<p>Main picture:</p>
				</td><td>
					<input name=photo1 id=photo1 type=file size=30 onChange='if (document.getElementById("photo1").value!="") document.getElementById("photo2").disabled=false; else {document.getElementById("photo2").disabled=true;document.getElementById("photo3").disabled=true;document.getElementById("photo4").disabled=true;}' accept="image/jpeg,image/png">
				</td></tr><tr><td>
					<p>Other pictures:</p>
				</td><td>
					<input name=photo2 id=photo2 type=file size=30 disabled onChange='if (document.getElementById("photo2").value!="") document.getElementById("photo3").disabled=false; else {document.getElementById("photo3").disabled=true;document.getElementById("photo4").disabled=true;}' accept="image/jpeg,image/png">
				</td></tr><tr><td>
				</td><td>
					<input name=photo3 id=photo3 type=file size=30 disabled onChange='if (document.getElementById("photo3").value!="") document.getElementById("photo4").disabled=false; else document.getElementById("photo4").disabled=true;' accept="image/jpeg,image/png">
				</td></tr><tr><td>
				</td><td>
					<input name=photo4 id=photo4 type=file size=30 disabled>
				</td></tr></table>
<!--
Pour la section modif, des cases à cocher pour, le cas échéant, effacer une image du serveur.
-->
			</td></tr></table>
			<button type=submit name=tache value="nouvelle" class=centre>Submit</button>
			</form>
		</div>
<!-- fin de formulaire de création d'une offre -->
<?php
while($ChaqueOffre=mysql_fetch_array($InfosOffres,MYSQL_ASSOC)) {
// à peu près le même formulaire que pour la création d'une offre, mais pré-remplie, et avec quelques champs fixes
echo "<!-- début de formulaire de modification de l'offre numéro {$ChaqueOffre['ref']} -->\n";
echo "		<div id=indiv{$ChaqueOffre['ref']} style='display:none'>\n";
echo "			<form action=majOffres.php method=post onSubmit='return verifM({$ChaqueOffre['ref']});' name=modifO{$ChaqueOffre['ref']} enctype='multipart/form-data'>\n";
echo "			<p>Reference number: {$ChaqueOffre['ref']}</p>\n";
/*
//	En cas de désactivation d'un offre
if (!$ChaqueOffre['valide'])
	echo"			<p>Cette offre est désactivée: aucune recherche ne pourra la trouver.</p>\n";
*/

echo "			<input type=hidden name=refoffre id=refoffreM{$ChaqueOffre['ref']} value={$ChaqueOffre['ref']}>\n";
echo "			<input type=hidden id=utilM{$ChaqueOffre['ref']} value={$_SESSION['id']} name=util>\n";
?>
			<table class=centre cellpadding=20 !border cellspacing=30>
			<tr><td class=boite>
				<p>Country: <?php echo$ChaqueOffre['pays']?></p>
				<p>Area: <?php echo$ChaqueOffre['region']?></p>
				<hr>
				<p><label for=lieuM<?php echo$ChaqueOffre['ref']?>>Address:</label></p><textarea id=lieuM<?php echo$ChaqueOffre['ref']?> name=lieu rows=4 cols=30><?php echo$ChaqueOffre['adresse']?></textarea>
			</td><td rowspan=2 class=boite>
				<table><tr><td>
				<p>This offer is valid:</p>
				</td><td class=gauche>
				<p><label><input type=radio name=duree id=duree1M<?php echo$ChaqueOffre['ref']?> value='1' onClick='document.getElementById("anneeDM<?php echo$ChaqueOffre['ref']?>").disabled=false;document.getElementById("anneeDM<?php echo$ChaqueOffre['ref']?>").focus()'<?php echo($ChaqueOffre['duree']=="1")?" checked":""?>> only once &rarr;</label></p>
				<p><label><input type=radio name=duree id=duree2M<?php echo$ChaqueOffre['ref']?> value='+' onClick='document.getElementById("anneeDM<?php echo$ChaqueOffre['ref']?>").disabled=true;'<?php echo($ChaqueOffre['duree']=="+")?" checked":""?>> every year</label></p>
				</td><td>
				<p><label for=anneeD>Which year?</label></p>
				<p><input name=anneeD id=anneeDM<?php echo $ChaqueOffre['ref'].(($ChaqueOffre['duree']=="+")?" disabled":" value={$ChaqueOffre['annee']}")?> size=4 maxlength=4></p>
				</td></tr></table>
				<hr>
				<table><tr><td>
				<p>This offer is for:</p>
				</td><td class=gauche>
				<p><label><input type=checkbox name=sp id=spM<?php echo$ChaqueOffre['ref']?> value=1<?php echo(strpos($ChaqueOffre['saisons'],"1"))!==FALSE?" checked":""?>>Spring</label></p>
				<p><label><input type=checkbox name=se id=seM<?php echo$ChaqueOffre['ref']?> value=2<?php echo(strpos($ChaqueOffre['saisons'],"2"))!==FALSE?" checked":""?>>Summer</label></p>
				<p><label><input type=checkbox name=sa id=saM<?php echo$ChaqueOffre['ref']?> value=3<?php echo(strpos($ChaqueOffre['saisons'],"3"))!==FALSE?" checked":""?>>Autumn</label></p>
				<p><label><input type=checkbox name=sh id=shM<?php echo$ChaqueOffre['ref']?> value=4<?php echo(strpos($ChaqueOffre['saisons'],"4"))!==FALSE?" checked":""?>>Winter</label></p>
				</td></tr></table>
				<hr>
				<p><label for=datesprecisesM>Dates:<label></p>
				<textarea rows=2 cols=30 name=datesprecises id=datesprecisesM<?php echo$ChaqueOffre['ref']?>><?php echo$ChaqueOffre['dates']?></textarea>
			</td></tr><tr><td rowspan=2 class=boite>
				<div class=gauche>
				<p><label><input type=checkbox name=jardin<?php echo($ChaqueOffre['jardin'])?" checked":""?>>Garden</label></p>
				<p><label><input type=checkbox name=garage<?php echo($ChaqueOffre['garage'])?" checked":""?>>Garage</label></p>
				<p><label><input type=checkbox name=voiture<?php echo($ChaqueOffre['voiture'])?" checked":""?>>Car loan</label></p>
				<p><label><input type=checkbox name=tele<?php echo($ChaqueOffre['tele'])?" checked":""?>>Television</label></p>
				<p><label><input type=checkbox name=conint<?php echo($ChaqueOffre['conint'])?" checked":""?>>Internet</label></p>
				<hr>
				<p><label><input type=checkbox name=mer<?php echo($ChaqueOffre['mer'])?" checked":""?>>Near the sea</label></p>
				<p><label><input type=checkbox name=montagne<?php echo($ChaqueOffre['montagne'])?" checked":""?>>Near mountains</label></p>
				<p><label><input type=checkbox name=campagne<?php echo($ChaqueOffre['campagne'])?" checked":""?>>Near the countryside</label></p>
				<p><label><input type=checkbox name=cville<?php echo($ChaqueOffre['cville'])?" checked":""?>>In the town centre</label></p>
				<p><label><input type=checkbox name=banlieue<?php echo($ChaqueOffre['banlieue'])?" checked":""?>>In the suburbs</label></p>
				<hr>
				<p><label><input type=checkbox name=enfants<?php echo($ChaqueOffre['enfants'])?" checked":""?>>Children welcome</label></p>
				<p><label><input type=checkbox name=animaux<?php echo($ChaqueOffre['animaux'])?" checked":""?>>Pets welcome</label></p>
				<p><label><input type=checkbox name=fumeurs<?php echo($ChaqueOffre['fumeurs'])?" checked":""?>>Smokers welcome</label></p>
				</div>
			</td></tr><tr><td class=boite>
				<p><label for=typelogM<?php echo$ChaqueOffre['ref']?>>Type of lodging:</label></p>
				<select name=typelog id=typelogM<?php echo$ChaqueOffre['ref']?>>
				<option value="aucun">Choose one</option>
				<option value=appartement<?php echo($ChaqueOffre['type']=='appartement')?" selected":""?>>Appartment</option>
				<option value=chalet<?php echo($ChaqueOffre['type']=='chalet')?" selected":""?>>Chalet</option>
				<option value=chaumiere<?php echo($ChaqueOffre['type']=='chaumiere')?" selected":""?>>Cottage</option>
				<option value=loft<?php echo($ChaqueOffre['type']=='loft')?" selected":""?>>Loft</option>
				<option value=manoir<?php echo($ChaqueOffre['type']=='manoir')?" selected":""?>>Mansion</option>
				<option value=autre<?php echo($ChaqueOffre['type']=='autre')?" selected":""?>>Other</option>
				</select>
				<hr>
				<p><label for=litsM<?php echo$ChaqueOffre['ref']?>>Number of places:</label></p>
				<select name=lits id=litsM<?php echo$ChaqueOffre['ref']?>>
				<option value="aucun">Choose one</option>
				<option value=1<?php echo($ChaqueOffre['couchages']=='1')?" selected":""?>>One</option>
				<option value=2<?php echo($ChaqueOffre['couchages']=='2')?" selected":""?>>Two places</option>
				<option value=3<?php echo($ChaqueOffre['couchages']=='3')?" selected":""?>>Three places</option>
				<option value=4<?php echo($ChaqueOffre['couchages']=='4')?" selected":""?>>Four places</option>
				<option value=5<?php echo($ChaqueOffre['couchages']=='5')?" selected":""?>>Five places</option>
				<option value=6<?php echo($ChaqueOffre['couchages']=='6')?" selected":""?>>Six places</option>
				<option value=7<?php echo($ChaqueOffre['couchages']=='7')?" selected":""?>>Seven places</option>
				<option value=8<?php echo($ChaqueOffre['couchages']=='8')?" selected":""?>>Eight places</option>
				<option value=9<?php echo($ChaqueOffre['couchages']=='9')?" selected":""?>>Nine places</option>
				<option value=10<?php echo($ChaqueOffre['couchages']=='10')?" selected":""?>>Ten places</option>
				<option value=11<?php echo($ChaqueOffre['couchages']=='11')?" selected":""?>>Over ten</option>
				</select>
				<hr>
				<p><label for=descriM<?php echo$ChaqueOffre['ref']?>>Description:</label></p>
				<textarea rows=6 cols=50 id=descriM<?php echo$ChaqueOffre['ref']?> name=descri><?php echo$ChaqueOffre['descri']?></textarea>
			</td></tr><tr><td colspan=2 class=boite>
<!--				<p class=antoine>Aussi une option pour effacer une photo? ( =&gt; étiquetage par numéro).</p>-->
				<input type=hidden name='MAX_FILE_SIZE' value='200000'>
				<table width=100% class=centre><tr>
<?php
$photos=glob("./photos/".$ChaqueOffre['ref'].".*");
if(count($photos)>=1) {
	foreach($photos as $w=>$x) {
		$w++;
		echo"				<td><img src=\"".$x."\" height=150 width=200><br>\n";
		echo"					<p>Change this picture:</p>\n";
		echo"					<input name=photo$w type=file size=15></td>\n"; }
if(count($photos)<4) {
	$w++;
	echo"				<td><p>Add a picture:</p>\n";
	echo"					<input name=photo$w type=file size=15></td>\n"; }
} else { ?>
				<td><p>Add a picture:</p>
					<input name=photo1 type=file size=30></td>
<?php } ?>
				</tr></table>
			</tr></table>
<!--
			<button name=tache value=maj type=submit>Mise à jour</button> <button type=submit class=danger name=tache value=effacer onClick="return confirm('Etes-vous sûr de vouloir\neffacer cette offre d\'échange?');">Effacer cette offre</button>
-->
			<button type=submit onClick='document.getElementById("modif<?php echo$ChaqueOffre['ref']?>").value="maj";'>Update</button>
			<button type=submit class=danger onClick="return confirm('Etes-vous sûr de vouloir\neffacer cette offre d\'échange?');document.getElementById('submit<?php echo$ChaqueOffre['ref']?>').value='effacer';">Delete</button>
			<input type=hidden id="modif<?php echo$ChaqueOffre['ref']?>" name=tache>
			</form>
		</div>
<!-- fin de formulaire de modification de l'offre numéro <?php echo$ChaqueOffre['ref']?> -->
<?php } ?>
		</tr></td></table>
	</div>
	<!--
	Fin du deuxième bloc
	-->
	<div style='display:none' id="compte" class=centre>
	<!--
	Troisième bloc
	-->
		<form action="CompteConf.php" method=post onSubmit='return verifC();' name=maj_compte>
		<table border class=centre cellpadding=15>
		<tr><td>
			<p>This is where you can update your account.</p>
			<p>All information contained here is strictly limited to confirmed Mensa members.</p>
			<table cellpadding=20 cellspacing=30>
			<tr><td class=boite>
				<table style='text-align:left'>
				<tr><td>
					<p><label for=prenom>First name (optional):</label></p>
				</td><td>
					<input size=25 name=prenom id=prenom value="<?php echo $InfosCompte['prenom']?>">
				</td></tr><tr><td>
					<p><label for=patro>Surname (required):</label></p>
				</td><td>
					<input size=25 name=patro id=patro value="<?php echo$InfosCompte['nom']?>">
					<label><input type=radio name=prefixe id=pm1 value="M."<?php echo ($InfosCompte['prefixe']=="M.")?" checked":"" ?>>Mr</label>
					<label><input type=radio name=prefixe id=pm2 value="Mme"<?php echo ($InfosCompte['prefixe']=="Mme")?" checked":"" ?>>Mrs</label>
					<label><input type=radio name=prefixe id=pm3 value="Mlle"<?php echo ($InfosCompte['prefixe']=="Mlle")?" checked":"" ?>>Miss</label>
				</td></tr><tr><td>
					<p><label for=contact>Contact information:</label></p>
					<p><label for=contact>(e.g. e-mail, snail mail...)</label></p>
				</td><td>
					<textarea rows=5 cols=30 name=contact id=contact><?php echo $InfosCompte['contact']?></textarea>
				</td></tr><tr><td>
					<p><label for=pays>National Mensa:</label></p>
				</td><td>
					<select name=pays id=pays>
<?php
foreach(file('MTrocListePays.ini',FILE_IGNORE_NEW_LINES)as$pays) {
	$x=($InfosCompte['pays']==$pays)?" selected":"";
	echo"					<option$x>$pays</option>\n"; }
?>
				</td></tr><tr><td>
					<p><label for=langue>Preferred language:</label></p>
				</td><td>
					<select name=langue id=langue>
<?php
foreach(file('MTrocListeLangues.ini',FILE_IGNORE_NEW_LINES)as$langue) {
	$x=($InfosCompte['langue']==$langue)?" selected":"";
	echo"					<option$x>$langue</option>\n"; }
?>
					</select>
				</td></tr></table>
			</td></tr><tr><td class=boite>
				<table width=100%>
				<tr><td>
					<p><label for=login>Login:</label></p>
				</td><td>
					<input size=25 name=login id=login value="<?php echo $InfosCompte['login']?>">
				</td></tr><tr><td>
					<p><label for=mdp1>Password:</label></p>
				</td><td>
					<input size=25 type=password name=mdp1 id=mdp1>
				</td></tr><tr><td>
					<p><label for=mdp2>Confirm password:</label></p>
				</td><td>
					<input size=25 type=password name=mdp2 id=mdp2>
				</td></tr></table>
			</td></tr></table>
			<input type=hidden name='iden' value=<?php echo $InfosCompte['id']?>>
<!-- 'iden' sert d'indicateur de mise à jour au lieu de création -->
			<button class=centre type=submit>Update</button>
		</td></tr>
		</table>
		</form>
	</div>
	<!--
	Fin du troisième bloc
	-->
<?php if ($InfosCompte['modo']) { ?>
	<div style='display:none' id="modo" class=centre>
	<!--
	Quatrième bloc, disponible UNIQUEMENT aux modérateurs/gestionnaires
	-->
	<table class=centre border cellpadding=15 width=95%>
	<tr><td>
<!--
Modo 1 (petit chef) -> liste des comptes nationaux par nom, affichage des noms et validités (ces dernières clairement différenciées). Boîte dépliante avec langue, bouton validation/invalidation (et avertissement), offres et accès aux forums: messages par le tenant du compte (avec modération) et messages sur le tenant du compte. Forums: modos nationaux, tous les modos. Liste des comptes modos par pays, nom? (pour communiquer entre eux)
Modo 2 (grand chef) -> liste de tous les comptes par nom et par pays, affichage des noms et pays et langues et niveaux modo, bouton validation/invalidation, fonction ajustage du niveau modo (autres modifs?). Accès aux forums idem, mais avec modération? Accès au formulaire de chargement de nouveaux pays et nouvelles langues?
-->
<?php
if ($InfosCompte['modo']==1)
	$liste="select id,prefixe,prenom,nom,pays,langue,contact,valide,modo,date_creation as di, date_connexion as dc from utils where pays='".$InfosCompte['pays']."' order by nom,prenom";
if ($InfosCompte['modo']==2)
	$liste="select id,prefixe,prenom,nom,pays,langue,contact,valide,modo,date_creation as di, date_connexion as dc from utils order by nom,prenom";
$liste=mysql_query($liste);
while ($x=mysql_fetch_array($liste)) {
	echo "		<form method=post action='modo.php' name=comptes>\n";
	echo "		<input type=hidden name=compte value={$x['id']}>\n";
	echo "		<table width=95%><tr><td width=45% class=gauche>\n";
	$v=$x['valide']?'Confirmed <img src=vert.gif>':'Unconfirmed <img src=rouge.gif>';
	echo "			<p>{$x['prefixe']} <b>{$x['nom']}, {$x['prenom']}</b></p>\n";
	echo "		</td><td>\n";
//	echo "			<p>$v <button type=submit name='quefaire' onClick='return confirm(\"Etes-vous certain de vouloir valider / invalider le compte suivant:\\n\\n{$x['prenom']} {$x['nom']}?\")' value='valide'>Valider/Invalider</button>\n";
// Avertissement: Internet Explorer ne reconnait pas ce bouton correctement (cf. ci-dessous). La ligne suivante rend compatible.
	echo "			<p>$v <button type=submit onClick='document.getElementById(\"quefaire{$x['id']}\").value=\"valide\";return confirm(\"Are you sure you wish to confirm/unconfirm the following account:\\n\\n{$x['prenom']} {$x['nom']}?\")'>Confirm/Unconfirm</button>\n";
	echo "		</td><td>\n";
	echo "			<button type=button onClick=\"montrer('mcompte{$x['id']}')\">Account details</button>\n";
// Autre option: simple montrer/cacher, sans rapport avec l'arborescence de la page.
	echo "		</td></tr><tr><td colspan=4 !class=boite>\n";
	echo "		<div id=mcompte{$x['id']} style='display:none'>\n";
	echo "			<table width=100% class=data style='border-style:ridge'><tr><td !width=50%>\n";
	$p=($InfosCompte['modo']==2)?"<b>Country</b>: {$x['pays']}, ":"";
	echo"				<p>$p<b>Language</b>: {$x['langue']}</p>\n";
	echo"			</td><td rowspan=2>\n";
	echo"				<p>Account creation: ".date_en_clair(strtotime($x['di']))."</p>\n";
	if (($dc=date_en_clair(strtotime($x['dc'])))=="(<i>unspecified</i>)") $dc="none";
	echo"				<p>Last connection: $dc</p>\n";
	echo"			</td><td rowspan=2>\n";
	$cont=ereg_replace("/\r\n|\r|\n/","&nbsp;</p>\n				<p>",$x['contact']);
	echo "				<p><b>Contact info</b>:</p>\n				<p>$cont</p>\n";
	echo "			</td></tr><tr><td>\n";
	$mod=array("none","national mod","head of SIG");
	if ($InfosCompte['modo']==2) {
		echo "				<p><b>Mod level</b>:\n";
		echo "				<select id=niv{$x['id']}>\n";
		foreach ($mod as $y=>$z)
			echo "				<option value='niveau§$y'".($x['modo']==$y?" selected":"").">$z</option>\n";
		echo "				</select>\n";
//		echo "				<button type=submit id='aj{$x['id']}' name='quefaire' onClick='document.getElementById(\"aj{$x['id']}\").value=document.getElementById(\"niv{$x['id']}\").value;'>Ajuster</button></p>\n";
// En cliquant sur 'Valider/Invalider', IE vient chercher ici une valeur inexistante ('Ajuster'). La ligne suivante rend compatible.
		echo "				<button type=submit id='aj{$x['id']}' onClick='document.getElementById(\"quefaire{$x['id']}\").value=document.getElementById(\"niv{$x['id']}\").value;'>Adjust</button></p>\n";
	} else echo "				<p><b>Mod level</b>: {$mod[$x['modo']]}</p>\n";
		
	echo "			</td></tr></table>\n";
	echo "		</div>\n";
	echo "		</td></tr></table>\n";
	echo "		<input type=hidden id='quefaire{$x['id']}' name='quefaire'>\n";
	echo "		</form>\n"; }
// Il reste a faire la modération des commentaires. Recherche d'un ensemble de commentaires par offre / par commentateur, puis charcutage.
?>
	</td></tr>
	</table>
	</div>
	<!--
	Fin du quatrième bloc
	-->
	<div style='display:none' id="forum" class=centre>
	<!--
	Cinquième bloc, disponible UNIQUEMENT aux modérateurs/gestionnaires
	-->
	<table class=centre border cellpadding=15 width=95%>
	<tr><td>
<!--
	<p>Ici se trouvera le forum pour les modos, selon le niveau (petit ou grand chef)</p>
	<p>Ou alors juste des liens vers les discussions, dans une nouvelle fenêtre.</p>
-->
	<p class=antoine>Vous souhaitez traduire le site dans votre langue? Il y aura ici le guide <a !href="MTrocTradEn.zip">en anglais</a> et <a !href="MTrocTradFr.zip">en français</a> (et éventuellement d'autres langues, si quelqu'un veut les traduire).</p>
	</td></tr>
	</table>
	</div>
	<?php } ?>
</body>
</html>
<?php } ?>
