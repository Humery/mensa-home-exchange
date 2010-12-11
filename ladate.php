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
	$Jour="(<i>unspecified</i>)";
else {
	$Jour=date("l",$moment)." the ".(date("jS",$moment))." of ".date("F",$moment);
	if (date("Y",$moment)!=date("Y"))
		$Jour.=" ".date("Y",$moment); }
return $Jour; }
//$Jour is a string
?>