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
	<p>Il semble y avoir un probl�me. <a href="index.php">Revenez � la page d'accueil</a> pour confirmer votre identit�. Si le probl�me persiste, n'h�sitez pas � contacter votre responsable national du GIS.</p>
</body>
</html>
<?php
} else {
?>
	<div class=centre><img width=800 height=100 alt="Ici, encore un joli dessin" src="MTrocEnTete.jpeg"></div>
	<h1>Foire Aux Questions</h1>
	<p>Si vous avez une difficult� a utiliser le site, lisez la FAQ. Puis, relisez-la. Apr�s, si vous n'avez toujours pas trouv� de r�ponse, vous pouvez demander � votre mod�rateur national.</p>
	<p>(<a href='accueil.php'>Retour � la page principale</a>)</p>
	<p style='font-weight:bold'>Questions</p>
	<ul>
		<li><a href="#ManqueRegions">Pouquoi manque-t-il des r�gions dans la s�lection "<i>r�gion approximative</i>" de la recherche?</a>
		<li><a href="#NumeroDuneOffre">Comment faire pour connaitre le num�ro d'une offre?</a>
		<li><a href="#VoirToutesOffres">Comment faire pour voir toutes les offres d'une r�gion?</a>
		<li><a href="#OffreManquante">Pourquoi mes offres n'apparaissent-elles pas lors d'une recherche?</a>
		<li><a href="#PhotosTordues">Les photos de mon offres sont d�form�es ou n'apparaissent pas du tout. Pourquoi?</a>
		<li><a href="#GIFmanquante">Certaines images n'apparaissent pas dans les fichiers PDF des offres. Pourquoi pas?</a>
		<li><a href="#RechercheVide">Pourquoi est-ce que ma recherche ne trouve aucune offre?</a>
	</ul>
	<hr width=75%>
	<ul>
		<li><a name="ManqueRegions"><b>Pouquoi manque-t-il des r�gions dans la s�lection "<i>r�gion approximative</i>" de la recherche?</b></a>
		<li class=none>Cette liste ne donne que les r�gions pour lesquelles il y a au moins une offre. Une r�gion sans aucune offre n'est donc pas affich�e et ne peut �tre choisie.
		<li><a name="NumeroDuneOffre"><b>Comment faire pour connaitre le num�ro d'une offre?</b></a>
		<li class=none>La description d'une offre comporte son num�ro. Cette fonction sert essentiellement � retrouver rapidement une offre sp�cifique.
		<li><a name="VoirToutesOffres"><b>Comment faire pour voir toutes les offres d'une r�gion?</b></a>
		<li class=none>Seule la r�gion est obligatoire lors d'une recherche: vous pouvez donc laisser tous les autres champs vides.
		<li><a name="OffreManquante"><b>Pourquoi mes offres n'apparaissent-elles pas lors d'une recherche?</b></a>
		<li class=none>Le moteur de recherche ne montre pas � un utilisateur ses propres offres; pour y acc�der, le plus simple est d'utiliser la section "<i>g�rer vos offres</i>". Toutefois, si vous souhaitez voir votre offre comme la verront les autres, vous pouvez la rechercher par son num�ro (ce num�ro aussi est disponible dans la section "<i>g�rer vos offres</i>", juste sous le menu d�roulant "<i>Modifier une offre</i>").
		<li><a name="PhotosTordues"><b>Les photos de mon offre sont d�form�es ou n'apparaissent pas du tout. Pourquoi?</b></a>
		<li class=none>Comme indiqu� par le bouton "<i>&rarr; Instructions pour les photos &larr;</i>", les photos doivent ob�ir � certaines r�gles. Elles doivent �tre dans un format courant, c'est-�-dire JPEG (.jpg ou .jpeg), GIF ou PNG. Quelles que soient leurs dimensions d'origine, elles sont automatiquement affich�es en 400 points de large par 300 points de haut. De m�me, elles ne doivent pas d�passer 200 Ko (ce qui, normalement, est largement suffisant pour des photos de cette taille) sinon elles ne sont pas t�l�charg�es correctement. Si votre photo ne correspond pas � ces crit�res, vous pouvez assez facilement la modifier gr�ce � n'importe quel �diteur graphique (ou si vous �tes allergique � ce genre de chose, demandez � un ami moins allergique que vous).
		<li><a name="GIFmanquante"><b>Certaines images n'apparaissent pas dans les fichiers PDF des offres. Pourquoi pas?</b></a>
		<li class=none>Comme indiqu� par le bouton "<i>&rarr; Instructions pour les photos &larr;</i>", les photos doivent ob�ir � certaines r�gles. Les images au format GIF sont affich�es sur le site mais une difficult� technique les emp�che d'�tre incluses dans les fichiers PDF des offres. L� aussi, vous pouvez assez facilement enregistrer vos images dans un autre format (personnellement, je vous conseille le PNG: il arrive que le JPEG floute les images un peu) gr�ce � n'importe quel �diteur graphique.
		<li><a name="RechercheVide"><b>Pourquoi est-ce que ma recherche ne trouve aucune offre?</b></a>
		<li class=none>Vaste question. Si vous avez pr�cis� plusieurs crit�res de recherche, le plus probable est qu'il existe des offres dans la r�gion, mais aucune d'entre elles ne correspond exactement � vos souhaits. Essayez de refaire la m�me recherche mais en r�duisant le nombre de crit�res. Si vous avez fait une recherche en ne pr�cisant que la r�gion, et vous n'avez quand m�me eu aucun r�sultat, f�licitations: vous avez trouv� un bug! Veuillez le signaler � votre mod�rateur national en pr�cisant la r�gion qui pose probl�me; l'�quipe tentera de comprendre ce qui se passe pour y rem�dier.
	</ul>
	<p><a href='accueil.php'>Retour � la page principale</a></p>
</body>
</html>
<?php } ?>