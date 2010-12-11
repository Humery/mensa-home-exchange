<?php session_start() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php
echo(isset($_SESSION['id']))?"	<title>M'Troc | Foire Aux Questions</title>":"	<title>M'Troc</title>";
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
	<p>Il semble y avoir un problème. <a href="index.php">Revenez à la page d'accueil</a> pour confirmer votre identité. Si le problème persiste, n'hésitez pas à contacter votre responsable national du GIS.</p>
</body>
</html>
<?php
} else {
?>
	<div class=centre><img width=800 height=100 alt="Ici, encore un joli dessin" src="MTrocEnTete.jpeg"></div>
	<h1>Foire Aux Questions</h1>
	<p>Si vous avez une difficulté a utiliser le site, lisez la FAQ. Puis, relisez-la. Après, si vous n'avez toujours pas trouvé de réponse, vous pouvez demander à votre modérateur national.</p>
	<p>(<a href='accueil.php'>Retour à la page principale</a>)</p>
	<p style='font-weight:bold'>Questions</p>
	<ul>
		<li><a href="#ManqueRegions">Pouquoi manque-t-il des régions dans la sélection "<i>région approximative</i>" de la recherche?</a>
		<li><a href="#NumeroDuneOffre">Comment faire pour connaitre le numéro d'une offre?</a>
		<li><a href="#VoirToutesOffres">Comment faire pour voir toutes les offres d'une région?</a>
		<li><a href="#OffreManquante">Pourquoi mes offres n'apparaissent-elles pas lors d'une recherche?</a>
		<li><a href="#PhotosTordues">Les photos de mon offres sont déformées ou n'apparaissent pas du tout. Pourquoi?</a>
		<li><a href="#GIFmanquante">Certaines images n'apparaissent pas dans les fichiers PDF des offres. Pourquoi pas?</a>
		<li><a href="#RechercheVide">Pourquoi est-ce que ma recherche ne trouve aucune offre?</a>
	</ul>
	<hr width=75%>
	<ul>
		<li><a name="ManqueRegions"><b>Pouquoi manque-t-il des régions dans la sélection "<i>région approximative</i>" de la recherche?</b></a>
		<li class=none>Cette liste ne donne que les régions pour lesquelles il y a au moins une offre. Une région sans aucune offre n'est donc pas affichée et ne peut être choisie.
		<li><a name="NumeroDuneOffre"><b>Comment faire pour connaitre le numéro d'une offre?</b></a>
		<li class=none>La description d'une offre comporte son numéro. Cette fonction sert essentiellement à retrouver rapidement une offre spécifique.
		<li><a name="VoirToutesOffres"><b>Comment faire pour voir toutes les offres d'une région?</b></a>
		<li class=none>Seule la région est obligatoire lors d'une recherche: vous pouvez donc laisser tous les autres champs vides.
		<li><a name="OffreManquante"><b>Pourquoi mes offres n'apparaissent-elles pas lors d'une recherche?</b></a>
		<li class=none>Le moteur de recherche ne montre pas à un utilisateur ses propres offres; pour y accéder, le plus simple est d'utiliser la section "<i>gérer vos offres</i>". Toutefois, si vous souhaitez voir votre offre comme la verront les autres, vous pouvez la rechercher par son numéro (ce numéro aussi est disponible dans la section "<i>gérer vos offres</i>", juste sous le menu déroulant "<i>Modifier une offre</i>").
		<li><a name="PhotosTordues"><b>Les photos de mon offre sont déformées ou n'apparaissent pas du tout. Pourquoi?</b></a>
		<li class=none>Comme indiqué par le bouton "<i>&rarr; Instructions pour les photos &larr;</i>", les photos doivent obéir à certaines règles. Elles doivent être dans un format courant, c'est-à-dire JPEG (.jpg ou .jpeg), GIF ou PNG. Quelles que soient leurs dimensions d'origine, elles sont automatiquement affichées en 400 points de large par 300 points de haut. De même, elles ne doivent pas dépasser 200 Ko (ce qui, normalement, est largement suffisant pour des photos de cette taille) sinon elles ne sont pas téléchargées correctement. Si votre photo ne correspond pas à ces critères, vous pouvez assez facilement la modifier grâce à n'importe quel éditeur graphique (ou si vous êtes allergique à ce genre de chose, demandez à un ami moins allergique que vous).
		<li><a name="GIFmanquante"><b>Certaines images n'apparaissent pas dans les fichiers PDF des offres. Pourquoi pas?</b></a>
		<li class=none>Comme indiqué par le bouton "<i>&rarr; Instructions pour les photos &larr;</i>", les photos doivent obéir à certaines règles. Les images au format GIF sont affichées sur le site mais une difficulté technique les empèche d'être incluses dans les fichiers PDF des offres. Là aussi, vous pouvez assez facilement enregistrer vos images dans un autre format (personnellement, je vous conseille le PNG: il arrive que le JPEG floute les images un peu) grâce à n'importe quel éditeur graphique.
		<li><a name="RechercheVide"><b>Pourquoi est-ce que ma recherche ne trouve aucune offre?</b></a>
		<li class=none>Vaste question. Si vous avez précisé plusieurs critères de recherche, le plus probable est qu'il existe des offres dans la région, mais aucune d'entre elles ne correspond exactement à vos souhaits. Essayez de refaire la même recherche mais en réduisant le nombre de critères. Si vous avez fait une recherche en ne précisant que la région, et vous n'avez quand même eu aucun résultat, félicitations: vous avez trouvé un bug! Veuillez le signaler à votre modérateur national en précisant la région qui pose problème; l'équipe tentera de comprendre ce qui se passe pour y remédier.
	</ul>
	<p><a href='accueil.php'>Retour à la page principale</a></p>
</body>
</html>
<?php } ?>