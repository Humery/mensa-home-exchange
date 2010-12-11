<?php
// Ces variables sont à modifier en fonction du compte
/*
$url="localhost";
$compte="http";
$mdp="";
$bdd="mtroc";
*/
$url="localhost";
$compte="mhe";
$mdp="";
$bdd="mensafr4";
/*
A n'utiliser qu'une fois, lors de l'initialisation de la BDD
Au programme: création de la BDD, création des tableaux nécessaires dans la BDD, création des quelques comptes "grand chef", création d'un fichier connection.php puis autodestruction (effacement de CreerBDD.php); installation complète, nette et sans bavures.
*/
$connectionID=mysql_connect($url,$compte,$mdp);
if (!(mysql_fetch_array(mysql_query("show databases like '$bdd'"))))
$cbdd=mysql_query("create database '$bdd'");
//if ($cbdd) $ubdd=mysql_select_db($bdd);
$ubdd=mysql_select_db($bdd);
if ($ubdd) {
$ct1=mysql_query("create table utils (id smallint unsigned not null auto_increment primary key, login varchar(30), mdp varchar(32), prefixe varchar(5), prenom varchar(30), nom varchar(30), pays varchar(30), langue varchar(30), contact text, valide bool not null default false, modo tinyint(1) not null default 0, date_connexion timestamp default 0, date_creation timestamp default current_timestamp)"); //ou quelquechose dans ces eaux-là
$ct2=mysql_query("create table offres (ref smallint unsigned not null auto_increment primary key, util smallint unsigned, pays varchar(30), region varchar(30), adresse text, type varchar(30), couchages varchar(2), duree char(1), annee year(4), saisons varchar(4), dates text, descri text, jardin bool, garage bool, voiture bool, tele bool, conint bool, mer bool, montagne bool, campagne bool, cville bool, banlieue bool, enfants bool, animaux bool, fumeurs bool, date_creation timestamp default current_timestamp)");
$ct3=mysql_query("create table comm_utils (offreur smallint unsigned, messager smallint unsigned, moment datetime, message text, note bit(3))");
$ct4=mysql_query("create table comm_offres (offre smallint unsigned, messager smallint unsigned, moment datetime, message text, note bit(3))");
$ct5=mysql_query("create table comm_modos (messager tinyint(5), pays varchar(30), message text, moment timestamp default current_timestamp, fini tinyint(1) not null default 0)"); }
$ct6=mysql_query("create table modos (id smallint unsigned not null primary key, courriel varchar(50))");
if (@$ct1)
$cc1=mysql_query("insert into utils values (NULL,'grandmaitre01',md5('motdepassebidon'),'M.','Antoine','Chassagnard','France','English','27260 Morainville','1','2',DEFAULT,DEFAULT)");
$cc2=mysql_query("insert into modos values (1, 'dooberik@yahoo.co.uk')");
$contenu="<?php\n\$connectionID=@mysql_connect(\"".$url."\",\"".$compte."\",\"".$mdp."\");\n\$dbexists=@mysql_select_db($bdd);\n?>";
$cf=file_put_contents("connection.php",$contenu);
?>
<html>
<head><title>M'Troc | initialisation de la base de données</title>
</head>
<body>
<?php
echo ($connectionID)?"<p>Connection au serveur réussie</p>\n":"<p>Connection au serveur échouée</p>\n";
echo @($cbdd)?"<p>base de données créé</p>\n":"<p>base de données pas créé (ce qui est probablement normal)</p>\n";
echo @($ubdd)?"<p>connexion à la BDD réussie</p>\n":"<p>connexion à la BDD échouée</p>\n";
echo @($ct1)?"<p>utils créé</p>\n":"<p>utils pas créé</p>\n";
echo @($ct2)?"<p>offres créé</p>\n":"<p>offres pas créé</p>\n";
echo @($ct6)?"<p>modos créé</p>\n":"<p>modos pas créé</p>\n";
echo @($ct3)?"<p>comm_utils créé</p>\n":"<p>comm_utils pas créé</p>\n";
echo @($ct4)?"<p>comm_offres créé</p>\n":"<p>comm_offres pas créé\n</p>";
echo @($ct5)?"<p>comm_modos créé</p>\n":"<p>comm_modos pas créé</p>\n";
echo @($cc1)?"<p>compte primaire créé</p>\n":"<p>compte primaire pas créé</p>\n";
echo @($cc1)?"<p>modo primaire créé</p>\n":"<p>modo primaire pas créé</p>\n";
echo ($cf)?"<p>fichier de connexion créé</p>\n":"<p>fichier de connexion pas créé</p>\n";
?>
<p>Ne pas oublier d'effacer ce fichier s'il ne le fait pas tout seul.</p>
</body>
</html>
<?php
// Attention: dynamitage!
//unlink('CreerBDD.php');
// En fait, un bon dynamitage est un peu plus compliqué. Il est impossible d'effacer un fichier ouvert. Il faudrait donc ouvrir un deuxième fichier qui efface le premier. L'idéal serait que le deuxième fichier soit temporaire, mais je ne pense pas qu'il soit possible d'exécuter un fichier temporaire.
// Ou alors, une subtilité qui ne me plaît pas autant mais qui a au moins l'avantage de fonctionner serait, à partir d'un autre fichier, de tester l'existence de celui-ci et, le cas échéant, de le lancer. Le problème alors serait que si quelqu'un d'autre arrive à introduire un fichier du même nom, c'est la porte ouverte.
?>
