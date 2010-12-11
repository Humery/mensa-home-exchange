<?php
function date_en_clair($moment) {
/*
$moment takes a Unix timestamp
strtotime() can very conveniently convert the following (at least) into Unix timestamps:
- YYYY-MM-DD hh:mm:ss (MySQL datetimes)
- Y{1,4}-M{1,2}-D{1,2}
(i think it must tap into the current datetime to compensate for insufficient data)
*/
//Warning: the actual value of $moment for 'uninitialised' varies by storage engine.
if ($moment==943916400||$moment=="")
	$Jour="(<i>date non-précisée</i>)";
else {
	$semaine=array("Mon"=>"lundi","Tue"=>"mardi","Wed"=>"mercredi","Thu"=>"jeudi","Fri"=>"vendredi","Sat"=>"samedi","Sun"=>"dimanche");
	$mois=array(1=>"janvier","fevrier","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","decembre");
	$Jour=$semaine[date("D",$moment)]." ".((date("j",$moment)==1)?"1er":date("j",$moment))." ".$mois[date("n",$moment)];
	if (date("Y",$moment)!=date("Y"))
		$Jour.=" ".date("Y",$moment); }
return $Jour; }
//$Jour is a string
?>