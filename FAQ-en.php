<?php session_start() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php
echo(isset($_SESSION['id']))?"	<title>Mensa Home Exchange | Frequently Asked Questions</title>":"	<title>Mensa home Exchange</title>";
?>
	<meta name="author" content="Antoine Chassagnard">
	<meta name="generator" content="Crimson Editor">
	<link rel="stylesheet" type="text/css" href="Ech.css">
	<link rel="shortcut icon" href="mensa.ico">
</head>
<body>
<?php
if (!isset($_SESSION['id'])) {
?>
	<div class=centre><img src=bigangry.gif></div>
	<p>There seems to be a problem with your session. <a href='index.php'>Please return to the first page and enter your login and password again</a> and if the problem remains, warn your national moderator.</p>
</body>
</html>
<?php
} else {
?>
	<div class=centre><!img width=800 height=100 alt="Ici, encore un joli dessin" src="MTrocEnTete.jpeg"></div>
	<h1>Frequently Asked Questions</h1>
	<p>If you are experiencing difficulties using this site, read the FAQ. Then read it again. If you still haven't found the answer to your question, you can ask your national moderator.</p>
	<p>(<a href='accueil.php'>Return to the main page</a>)</p>
	<p style='font-weight:bold'>Questions</p>
	<ul>
		<li><a href="#ManqueRegions">Why are some areas missing in the "<i>approximate region</i>" scrollbox?</a>
		<li><a href="#NumeroDuneOffre">How can I find the reference number for an offer?</a>
		<li><a href="#VoirToutesOffres">How can I find all the offers for a given area?</a>
		<li><a href="#OffreManquante">Why do my offers not appear when I search for them?</a>
		<li><a href="#PhotosTordues">My pictures are deformed or don't appear at all. Why?</a>
		<li><a href="#GIFmanquante">Some pictures don't show up in the PDF offer printouts. Why not?</a>
		<li><a href="#RechercheVide">Why does my search not find anything?</a>
	</ul>
	<hr width=75%>
	<ul>
		<li><a name="ManqueRegions"><b>Why are some areas missing in the "<i>approximate region</i>" scrollbox?</b></a>
		<li class=none>This list only contains areas for which there is at least one offer. Areas without any offers at all are therefore unavailable.
		<li><a name="NumeroDuneOffre"><b>How can I find the reference number for an offer?</b></a>
		<li class=none>The offer's description contains it's reference number. This is mainly useful for quickly finding a specific offer again.
		<li><a name="VoirToutesOffres"><b>How can I find all the offers for a given area?</b></a>
		<li class=none>The area is the only required criterion for a search: you can leave all the others blank.
		<li><a name="OffreManquante"><b>Why do my offers not appear when I search for them?</b></a>
		<li class=none>The search engine won't show a user his or her own offers; the simplest way to access them anyway is to use the "<i>manage your offers</i>" section. However, if you wish to see your offer as others see it, you can search for it by it's reference number (which can also be found in the "<i>manage your offers</i>" section, just under the "<i>Change an offer</i>" scrollbox).
		<li><a name="PhotosTordues"><b>My pictures are deformed or don't appear at all. Why?</b></a>
		<li class=none>As indicated by the "<i>&rarr; Instructions for the pictures &larr;</i>" button, the pictures must follow certain rules. They must be in a common format, i.e. JPEG (.jpeg or .jpg), GIF or PNG. Whatever their original height and width, they are automatically displayed in 400 wide by 300 high. They are also limited to 200Kb (which is normally plenty for a picture that size); larger files will not load properly. If your picture doesn't fit these criteria, you can easily alter it with any common graphic editor (or, if you're allergic to such things, you can ask a less allergic friend to do it for you).
		<li><a name="GIFmanquante"><b>Some pictures don't show up in the PDF offer printouts. Why not?</b></a>
		<li class=none>As indicated by the "<i>&rarr; Instructions for the pictures &larr;</i>" button, the pictures must follow certain rules. GIF files are displayed on-site but a technical difficulty prevents them from being included in the PDF files. This problem is also easy to solve: all common graphic editors can re-save your picture with a different format (personally, I recommend PNG: sometimes JPEG can do funny things to your pictures).
		<li><a name="RechercheVide"><b>Why does my search not find anything?</b></a>
		<li class=none>That's a pretty broad question. If you specified several search criteria, the likely explanation is that there are indeed offers for that area, but none which exactly fit your search parametres. Try the search again but with fewer criteria. If you ran a search based only on the area, congratulations: you have found a bug! Please warn your national moderator, indicating which area caused you trouble, and the team will try to understand what's going on and solve the problem.
	</ul>
	<p class="centre"><a href='accueil.php'>Return the main page</a></p>
</body>
</html>
<?php } ?>
