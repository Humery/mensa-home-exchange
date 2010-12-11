<?php
// Ce fichier est à appeller une seule fois, lors de l'initialisation du site.
// Au programme: création de la BDD, création des tableaux nécessaires dans la BDD, création du compte "grand chef" et création d'un fichier connection.php contenant les données de connexion.

// Les variables suivantes sont à modifier en fonction du compte

// Informations pour accéder à la base de données
$url="localhost";  // adresse du serveur du SGBD
$compte="mhe";     // login du compte du SGBD
$mdp="";     // mot de passe du compte
$bdd="mhe";        // nom de la base de données

// Informations du compte administrateur principal du site
$login="****";    // login
$mdp="****";      // mot de passe (en clair)
$titre="****";    // M. / Mme / Mlle
$prenom="****";
$patro="****";
$pays="****";
$langue="****";
$contact="****";  // comment vous contacter (adresse, tel...); pour faire un retour à la ligne: \n

$connectionID=mysql_connect($url,$compte,$mdp);
$cbdd=mysql_query("create database if not exists '$bdd'");
$ebdd=mysql_query("show databases like '$bdd'");
if ($ebdd) $ubdd=mysql_select_db($bdd); {
if ($ubdd) {
$ct1=mysql_query("create table utils (id smallint unsigned not null auto_increment primary key, login varchar(30), mdp varchar(32), prefixe varchar(5), prenom varchar(30), nom varchar(30), pays varchar(30), langue varchar(30), contact text, valide bool not null default false, modo tinyint(1) not null default 0, date_connexion timestamp default 0, date_creation timestamp default current_timestamp)");
$ct2=mysql_query("create table offres (ref smallint unsigned not null auto_increment primary key, util smallint unsigned, pays varchar(30), region varchar(30), adresse text, type varchar(30), couchages varchar(2), duree char(1), annee year(4), saisons varchar(4), dates text, descri text, jardin bool, garage bool, voiture bool, tele bool, conint bool, mer bool, montagne bool, campagne bool, cville bool, banlieue bool, enfants bool, animaux bool, fumeurs bool, date_creation timestamp default current_timestamp)");
$ct3=mysql_query("create table comm_utils (offreur smallint unsigned, messager smallint unsigned, moment datetime, message text, note bit(3))");
$ct4=mysql_query("create table comm_offres (offre smallint unsigned, messager smallint unsigned, moment datetime, message text, note bit(3))");
$ct5=mysql_query("create table comm_modos (messager tinyint(5), pays varchar(30), message text, moment timestamp default current_timestamp, fini tinyint(1) not null default 0)");
$ct6=mysql_query("create table modos (id smallint unsigned not null primary key, courriel varchar(50))");
if (@$ct1)
$cc1=mysql_query("insert into utils values (NULL,'$login',md5('$mdp'),'$titre','$prenom','$patro','$pays','$langue','$contact','1','2',DEFAULT,DEFAULT)");
if (@$ct6)
$cc2=mysql_query("insert into modos values (1, 'dooberik@yahoo.co.uk')"); }}
$contenu="<?php\n\$connectionID=@mysql_connect(\"".$url."\",\"".$compte."\",\"".$mdp."\");\n\$dbexists=@mysql_select_db($bdd);\n?>";
$cf=file_put_contents("connection.php",$contenu);
?>
<html>
<head><title>M'Troc | initialisation de la base de données</title>
</head>
<body>
<?php
echo ($connectionID)?"<p>Connection au serveur r&eacute;ussie</p>\n":"<p>Connection au serveur &eacute;chou&eacute;e</p>\n";
echo @($cbdd)?"<p>base de donn&eacute;es cr&eacute;&eacute;</p>\n":"<p>base de donn&eacute;es pas cr&eacute;&eacute; (ce qui est probablement normal)</p>\n";
if (@!$cbdd && @!$ebdd) echo "<p>La base de donn&eacute;es n'existe pas du tout, ce qui est d&eacute;ja moins normal.</p>\,";
echo @($ubdd)?"<p>connexion &agrave; la BDD r&eacute;ussie</p>\n":"<p>connexion &agrave; la BDD &eacute;chou&eacute;e</p>\n";
echo @($ct1)?"<p>utils cr&agrave;&agrave;</p>\n":"<p>utils pas cr&eacute;&eacute;</p>\n";
echo @($ct2)?"<p>offres cr&eacute;&eacute;</p>\n":"<p>offres pas cr&eacute;&eacute;</p>\n";
echo @($ct6)?"<p>modos cr&eacute;&eacute;</p>\n":"<p>modos pas cr&eacute;&eacute;</p>\n";
echo @($ct3)?"<p>comm_utils cr&eacute;&eacute;</p>\n":"<p>comm_utils pas cr&eacute;&eacute;</p>\n";
echo @($ct4)?"<p>comm_offres cr&eacute;&eacute;</p>\n":"<p>comm_offres pas cr&eacute;&eacute;\n</p>";
echo @($ct5)?"<p>comm_modos cr&eacute;&eacute;</p>\n":"<p>comm_modos pas cr&eacute;&eacute;</p>\n";
echo @($cc1)?"<p>compte primaire cr&eacute;&eacute;</p>\n":"<p>compte primaire pas cr&eacute;&eacute;</p>\n";
echo @($cc2)?"<p>modo primaire cr&eacute;&eacute;</p>\n":"<p>modo primaire pas cr&eacute;&eacute;</p>\n";
echo ($cf)?"<p>fichier de connexion cr&eacute;&eacute;</p>\n":"<p>fichier de connexion pas cr&eacute;&eacute;</p>\n";
?>
<p>Ne pas oublier d'effacer ce fichier.</p>
</body>
</html>
