<?php

$prefixe="M.";
$prenom="Albert";
$patro="Alzerberger";
$modo="tacredips@gmail.com";
$message=wordwrap("<p>$prefixe $prenom $patro a cr�� un compte au GIS M'Troc, et attend probablement que vous le validiez.</p><p>Avant de confirmer ce compte, n'oubliez pas de vous assurer qu'il s'agit bien d'un membre de Mensa � jour de cotisation.</p><p style='color:#777'>Ceci est un message g�n�r� automatiquement par le site M'Troc. N'y r�pondez pas.</p>",70);
$enplus="MIME-Version: 1.0\r\nContent-type:text/html;charset=iso-8859-15\r\n";
$enplus.="From:Otto Matique <robot@mtroc.org>\r\nReply-To:dooberik@yahoo.co.uk\r\n";
$enplus.="X-Mailer: PHP/".phpversion();
//$envoi=mail($modo,"(Message automatis�) Nouvel inscrit � M'Troc",$message,$enplus);


$envoi=mail("dooberik@yahoo.co.uk","Testing: 1, 2, 3","Success!","From: nobody@stupid.com");

?>
<html>
<head>
<title>Essai | envoi de courriel</title>
</head>
<body>
<?php
echo"<p style='text-decoration:underline;font-weight:bold'>Le message envoy�</p>\n";
echo"<pre>To:$modo</pre>\n";
echo"<pre>Subject:(Message automatis�) Nouvel inscrit � M'Troc</pre>\n";
$message=htmlspecialchars($message);
echo "<pre>Message:$message</pre>\n";
echo"<p>Additional headers:</p>\n";
echo"<pre>$enplus</pre>\n";
if($envoi)
	echo"<p style='text-decoration:underline;font-weight:bold'>e-mail sent</p>\n";
else {
	$pb=error_get_last();
	echo"<p style='text-decoration:underline;font-weight:bold'>e-mail not sent</p>\n";
	echo"<p><b>Type</b>: {$pb['type']}</p>\n";
	echo"<p><b>Message</b>: {$pb['message']}</p>\n";
	echo"<p><b>Line</b>: {$pb['line']}</p>\n"; }
?>
</body>
</html>