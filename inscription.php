<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Mensa Home Exchange website | Create an account</title>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor / vi">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
	<script language="javascript" src="scripts.js">
	</script>
</head>

<body>
	<h1>Create a <i>Mensa Home Exchange</i> SIG account</h1>
	<p>Welcome. Here, you can create an account which will allow you to post home exchange offers in the areas and at the times you wish (it's an inexpensive way to spend the holidays elsewhere) and consult such offers posted by other Mensa members.</p>
	<p>But let's start at the beginning <img src=minim.gif></p>
	<form action="CompteConf.php" method=post onSubmit='return verifC();' name=CreerUnCompte>
	<table !border class=centre cellpadding=15><tr><td class=boite>
		<table>
		<tr><td colspan=2>
			<h3>Some personal information if necessary to open an account.</h3>
			<p>This information is strictly limited to confirmed Mensa members.</p>
		</td></tr><tr><td>
			<p><label for=prenom>First name (optional):</label></p>
		</td><td>
			<input size=25 name=prenom id=prenom>
		</td></tr><tr><td>
			<p><label for=patro>Surname (required):</label></p>
		</td><td>
			<input size=25 name=patro id=patro>
			<label><input type=radio name=prefixe id=pm1 value="M.">Mr</label>
			<label><input type=radio name=prefixe id=pm2 value="Mme">Mrs</label>
			<label><input type=radio name=prefixe id=pm3 value="Mlle">Miss</label>
		</td></tr><tr><td>
			<p><label for=contact>Contact information:</label></p>
			<p><label for=contact>(e.g. e-mail, snail mail...)</label></p>
		</td><td>
			<textarea rows=5 cols=30 name=contact id=contact></textarea>
		</td></tr><tr><td>
			<p><label for=pays>National Mensa:</label></p>
		</td><td>
			<select name=pays id=pays>
			<option value="xx">Choose yours</option>
<?php
foreach(file('MTrocListePays.ini',FILE_IGNORE_NEW_LINES)as$x) {
	echo"			<option>$x</option>\n"; }
?>
			</select>
		</td></tr><tr><td>
			<p><label for=langue>Preferred language:</label></p>
		</td><td>
			<select name=langue id=langue>
			<option value="xx">Choose yours</option>
<?php
foreach(file('MTrocListeLangues.ini',FILE_IGNORE_NEW_LINES)as$x) {
	echo"			<option>$x</option>\n"; }
?>
			</select>
		</td></tr><tr><td>
		</table>
	</td></tr><tr><td class=boite>
		<table width=100%>
		<tr><td>
			<p><label for=login>Login:</label></p>
		</td><td>
			<input size=25 name=login id=login>
		</td></tr><tr><td>
			<p><label for=mdp1>Password:</label></p>
		</td><td>
			<input size=25 type=password name=mdp1 id=mdp1>
		</td></tr><tr><td>
			<p><label for=mdp2>Confirm password:</label></p>
		</td><td>
			<input size=25 type=password name=mdp2 id=mdp2>
		</td></tr>
		</table>
	</td></tr><tr><td>
		<center><button type=submit>Create your account!</button></center>
	</td></tr></table>
	</form>
</body>
</html>
