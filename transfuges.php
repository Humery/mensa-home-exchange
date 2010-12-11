<html>
<head>
<title>Insertion des transfuges</title>
<link rel="stylsheet" type="text/css" href="Ech.css">
</head>

<body>
<?php
include 'connection.php';
?>
<p><?php echo mysql_query("insert into utils values (DEFAULT,'pierre',md5('piyvdo9245'),'M.','Pierre-Yves','Domeneghetti','France','Français','domeneghetti.py@wanadoo.fr',1,0,DEFAULT,DEFAULT)")?"Pierre-Yves Domeneghetti réussi":"Pierre-Yves Domeneghetti raté"?></p>
</body>
</html>
