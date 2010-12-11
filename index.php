<?php
$langue=@$_COOKIE['langue']; //Nécessite ensuite un 'if ($langue)'
// Ou alors une analyse de cookies par javascript suivi d'une redirection automatique. En fait, index.php reste un nom de fichier parfaitement courant.
/*
Choix de la langue du site. Chacune n'est disponible qu'après traduction et en présence du fichier .lang.ini associé. Par défaut en anglais.
Receive language cookie value, check available language plug-in files.
Build page in chosen language, or English by default (but with flags).
Cookies:
- lasting, optional, contains language
- lasting, optional, contains login, retrieved by javascript
- lasting, optional, contains password, retrieved by javascript
- temporary, contains session-id
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-EN">
<head>
	<title>Mensa Home Exchange SIG site</title>
	<meta name="author" content="Antoine Chassagnard" />
	<meta name="generator" content="Crimson Editor / vi"/>
	<meta name="robots" content="index,nofollow" />
	<link rel="stylesheet" type="text/css" href="Ech.css"/>
	<link rel="shortcut icon" href="mensa.ico"/>
	<script type="text/javascript" src="scripts.js">
	</script>
</head>

<body onLoad="RappelCookies();" class=prem>
	<h1><i>Mensa Home Exchange</i> SIG site</h1>
	<a href="http://www.mensa.org/"><img style='float:left;margin:30pt;margin-top:0;border:none' src=LogoMensaTournoyant.gif alt="www.mensa.org" /></a>
	<h2><i>Mensa Home Exchange</i> is a SIG (Specific Interest Group), a part of <a href="http://www.mensa.org/">MENSA</a>. It's role is to allow contact between people who wish to exchange their homes for the holidays. Membership is reserved to current members of Mensa.</h2>
	<br clear=all />
	<p>This site (and the SIG) work entirely thanks to it's membership: the more offers are posted, the more are available. Encourage your Mensa friends and acquaintances to give it a try!</p>
	<div class=centre><!img width=800 height=150 alt="M'Troc website" src="MTrocEnTete.jpeg" /></div>
	<div class=centre><table !border class=centre><tr><td>
	<table border cellpadding=15 class=centre>
<!--
Accès au site et formulaire d'inscription.
-->
		<form action="accueil.php" method=post !onSubmit=**script** name=login>
		<tr><td>
		<table><tr><td>
		<p><label for=compte>Enter your login:</label></p>
		</td><td>
		<input ID=compte name=compte type=text size=25>
		</td></tr><tr><td>
		<p><label for=mdp>Enter your password:</label></p>
		</td><td>
		<input ID=mdp type=password name=mdp size=25>
		</td></tr>
		</table>
		<p><label>Would you like your computer to remember your<br>login and password (this requires a cookie)? <input type=checkbox name="garder"></label></p>
		<button type=submit onClick="CookieControl();">Confirm &rarr;</button>
		</form>
		</td></tr><tr><td>
		<div class=centre>
		<p>Are you new here?</p><button type=button onClick='self.location.href="inscription.php";'>Create an account</button>
		</div>
		</td></tr>
	</table>
	</td><td width=40></td><td>
		<table cellpadding=10><tr><td style='display:none'>
			<p><img height=40 width=60 alt="Français" src="drapeau.gif" /> Le site en Français</p>
		</td></tr><tr><td style='display:none'>
			<p><img height=39 width=60 alt="Deutsch" src="dienstflagge.gif" /> </p>
		</td></tr><tr><td style='display:none'>
			<p><img height=40 width=60 alt="English" src="flag-b.gif"/> <img height=39 width=60 src="flag-y.gif" /> Click here for the English version</p>
		</td></tr><tr><td style='display:none'>
			<p><img height=40 width=60 alt="Italiano" src="bandiera.gif" /> </p>
		</td></tr>
	</table>
	</td></tr></table></div>
	<div class=centre><p class=petit><img src="letter.gif" style="border:none" /> To contact the webmaster: mhe AT mensa DOT fr (and no spam, please).</p></div>
	<div class=legal>
	<h4>Legal notice</h4>
	<p class=petit>Any disputes between participants must be submitted to the international (or national, as the case may be) ombudsman before resorting to possible litigation, in accordance with the Constitution of Mensa International.</p>
	<p class=petit>Mensa Home Exchange is a service, provided free of charge to Mensa members. Neither its volunteer organisers nor Mensa itself may be held responsible in case of damages or disputes between participants.</p>
	<p class=petit>Participants are strongly advised to check with their insurance company before engaging in a home exchange.</p>
	</div>
	<div class=centre><p class=petit><i>This site is best viewed with <a href="http://www.mozilla.com/">Mozilla Firefox</a>. It also works in <span title="...but it was difficult.">Microsoft Internet Explorer.</span></i></p></div>
</body>
</html>
