function CookieControl() {
//	première page, pose les cookies (qui seront effacés tout de suite ou dans trois mois)
	souvenir=document.forms["login"].elements["garder"].checked;
	IDcompte=document.forms["login"].elements["compte"].value;
	MDPcompte=document.forms["login"].elements["mdp"].value;
	Expiration=new Date();
	if (souvenir==true)
		Expiration.setMonth(Expiration.getMonth()+3);
	document.cookie="MotDePasse="+MDPcompte+"; expires="+Expiration;
	document.cookie="Compte="+IDcompte+"; expires="+Expiration;
	document.cookie="Langue=Français; expires="+Expiration;
	document.cookie="Souvenir="+souvenir+"; expires="+Expiration;
	// La dernière ligne referme une petite faille de sécurité.
	if (IDcompte=="") document.forms["login"].elements["compte"].value="xxxx"; }

function RappelCookies() {
//	première page
	if (document.cookie!="") {
//	objet constituant un tableau associatif, contenant tous les cookies.
		z=new Array();
		var val={};
		z=document.cookie.split("; ");
		for(x=0;x<z.length;x++)
			val[z[x].split("=")[0]]=z[x].split("=")[1];
		if (val['Souvenir']=="true") {
			MDPcompte=val['MotDePasse'];
			IDcompte=val['Compte'];
			langpref=val['Langue'];
			souvenir=true;
		} else {
			IDcompte="";
			MDPcompte="";
			langpref="xx";
			souvenir=false; }
	} else {
		IDcompte="";
		MDPcompte="";
		langpref="xx";
		souvenir=false; }
	document.forms["login"].elements["compte"].value=IDcompte;
	document.forms["login"].elements["mdp"].value=MDPcompte;
	document.forms["login"].elements["garder"].checked=souvenir; }

var nouveau, ancien='recherche';
function montrer(nouveau) {
//	page principale
/*
Possibilité, en cas de profondeurs multiples réparties, que
ancien, nouveau = new Array()();
if (ancien(0)!=nouveau(0))
	document.getElementById(ancien(0)).style.display="none";
	document.getElementById(nouveau(0)).style.display="block";
// this next bit could be in a foreach type of loop on the passed array containing the path
foreach
	if (ancien(1)!=nouveau(1)) {
		if (ancien(1))
			document.getElementById(ancien(1)).style.display="none";
		if (nouveau(1))
			document.getElementById(nouveau(1)).style.display="block"; }
// that simple loop could just chug it's way through the whole hierarchy.
// is the next one even necessary?
if (ancien(0)==nouveau(0))
	document.getElementById(ancien(1)).style.display="none";
ancien=(nouveau(0),nouveau(1)); or just ancien=nouveau;
Il faudrait alors appeller cette fonction avec un tableau des éléments remontant au premier.
*/
	if (!(/^off/.test(ancien)&&/^ind|^Cre/.test(nouveau))&&!(/^mco/.test(nouveau)&&/^mod/.test(ancien)))
	document.getElementById(ancien).style.display="none";
	if (/^Cre|^ind/.test(ancien)&&!(/^Cre|^ind/.test(nouveau)))
	document.getElementById("offres").style.display="none";
	if (/^mco/.test(ancien)&&!(/^mco/.test(nouveau)))
	document.getElementById("modo").style.display="none";
	document.getElementById(nouveau).style.display="block";
	ancien=nouveau; }

function verifC() {
//	page principale et de création de compte
	if (document.getElementById("patro").value=="") {
		alert("You must fill in your family name.");
		document.getElementById("patro").focus();
		return false; }
	if (!(document.getElementById("pm1").checked||document.getElementById("pm2").checked||document.getElementById("pm3").checked)) {
		alert("Don't forget your marital status.");
		document.getElementById("pm1").focus();
		return false; }
	if (document.getElementById("contact").value=="") {
		alert("You must fill in your contact info.");
		document.getElementById("contact").focus();
		return false; }
	if (document.getElementById("pays").value=="Faites votre choix") {
		alert("You must fill in your national Mensa.");
		document.getElementById("pays").focus();
		return false; }
	if (document.getElementById("langue").value=="Faites votre choix") {
		alert("You must fill in your preferred language.");
		document.getElementById("langue").focus();
		return false; }
	if (document.getElementById("login").value=="") {
		alert("You must choose a login.");
		document.getElementById("login").focus();
		return false; }
	if (document.getElementById("login").value.length<5) {
		alert("Your login must be at least five characters long.");
		document.getElementById("login").focus();
		return false; }
	if (document.getElementById("mdp1").value=="") {
		alert("You must choose a password.");
		document.getElementById("mdp1").focus();
		return false; }
	if (document.getElementById("mdp1").value.length<5) {
		alert("Your password must be at least five characters long.");
		document.getElementById("mdp1").focus();
		return false; }
	if (document.getElementById("mdp2").value=="") {
		alert("You must confirm your password.");
		document.getElementById("mdp2").focus();
		return false; }
	if (document.getElementById("mdp1").value!=document.getElementById("mdp2").value) {
		alert("Password confirmation failed: please repeat.");
		document.getElementById("mdp1").value="";
		document.getElementById("mdp2").value=""
		document.getElementById("mdp1").focus();
		return false; }
	return true; }

function verifO() {
//	page principale, formulaire de création d'une offre
	if (document.getElementById("endroitO").value=="aucun") {
		alert("You must choose an area.");
		document.getElementById("endroitO").focus();
		return false; }
	if (document.getElementById("lieu").value=="") {
		alert("You must fill in the address.");
		document.getElementById("lieu").focus();
		return false; }
	if (!(document.getElementById("duree1").checked||document.getElementById("duree2").checked)) {
		alert("You must fill in the dates of availability.");
		document.getElementById("duree1").focus();
		return false; }
	if (document.getElementById("duree1").checked&&document.getElementById("anneeD").value=="") {
		alert("You must fill in the year of validity.");
		document.getElementById("anneeD").focus();
		return false; }
	if (document.getElementById("duree1").checked&&document.getElementById("anneeD").length<4) {
		alert("Please fill in a four-figure year.");
		document.getElementById("anneeD").focus();
		return false; }
	if (!(document.getElementById("sp").checked||document.getElementById("se").checked||document.getElementById("sa").checked||document.getElementById("sh").checked)) {
		alert("You must indicate the approximate time of availability (it's important for searches).");
		document.getElementById("sp").focus();
		return false; }
	if (document.getElementById("datesprecisesO").value=="") {
		alert("You must fill in precise dates of availability.");
		document.getElementById("datesprecisesO").focus();
		return false; }
	if (document.getElementById("typelog").value=="aucun") {
		alert("You must choose a type of lodging.");
		document.getElementById("typelog").focus();
		return false; }
	if (document.getElementById("lits").value=="aucun") {
		alert("You must indicate the number of places.");
		document.getElementById("lits").focus();
		return false; }
	if (document.getElementById("descri").value=="") {
		alert("Please describe the lodging.");
		document.getElementById("descri").focus();
		return false; }
	if (document.getElementById("photo1").value=="") {
//		Là, il faut une variable cachée indiquant la présence préalable d'une photo principale.
		return confirm("You haven't included a picture\nWould you like to continue anyway?");
		document.getElementById("photo1").focus();
		}
/*
Un bout de script qui détermine si les photos sont bien cataloguées dans la bonne balise
Peut-être aussi une mention du genre "n'oubliez pas les avertissements" (j'aime pas ce mot).
*/
}

function verifM(ref) {
// formulaire de modification d'une offre; à peu près comme verifO, mais avec 'ref' ajouté à tous les identifiants pour différencier les offres
	if (document.getElementById("lieuM"+ref).value=="") {
		alert("You must fill in the address.");
		document.getElementById("lieuM"+ref).focus();
		return false; }
	if (!(document.getElementById("duree1M"+ref).checked||document.getElementById("duree2M"+ref).checked)) {
		alert("You must fill in the dates of availability.");
		document.getElementById("duree1M"+ref).focus();
		return false; }
	if (document.getElementById("duree1M"+ref).checked&&document.getElementById("anneeDM"+ref).value=="") {
		alert("You must fill in the year of validity.");
		document.getElementById("anneeDM"+ref).focus();
		return false; }
	if (!(document.getElementById("spM"+ref).checked||document.getElementById("seM"+ref).checked||document.getElementById("saM"+ref).checked||document.getElementById("shM"+ref).checked)) {
		alert("You must indicate the approximate time of availability (it's important for searches).");
		document.getElementById("spM"+ref).focus();
		return false; }
	if (document.getElementById("datesprecisesM"+ref).value=="") {
		alert("Vous devez fournir des dates de disponibilité.");
		document.getElementById("datesprecisesM"+ref).focus();
		return false; }
	if (document.getElementById("typelogM"+ref).value=="aucun") {
		alert("You must choose a type of lodging.");
		document.getElementById("typelogM"+ref).focus();
		return false; }
	if (document.getElementById("litsM"+ref).value=="aucun") {
		alert("You must indicate the number of places.");
		document.getElementById("litsM"+ref).focus();
		return false; }
	if (document.getElementById("descriM"+ref).value=="") {
		alert("Please describe the lodging.");
		document.getElementById("descriM"+ref).focus();
		return false; }
/*	if (document.getElementById("photo1M"+ref).value=="") {
//		Là, il faut une variable cachée indiquant la présence préalable d'une photo principale.
		return confirm("Vous n'avez pas inclu de photo.\nSouhaitez-vous quand même continuer?");
		document.getElementById("photo1M"+ref).focus();
		}
*/ }

function verifR() {
// recherche d'offres; vérification de la validité de l'éventuel numéro de l'offre ainsi qu'un filtre obligeant au moins de choisir la région des recherches
	ref=document.getElementById('refR').value;
	if (ref!="") {
		if (ref>0&&ref<=99999)
			return true;
		else {
			alert("The reference number isn't a valid number.");
			return false;}}
	if (document.getElementById('endroitR').value=='aucune') {
		alert("You must select an area.");
		document.getElementById('endroitR').focus();
		return false; }
	return true; }

function photoguide() {
	message="Pictures are not required, but the team recommends you put at least one.\n\nThe first picture in the list will be displayed in the preliminary search results; the four together will be displayed in the full results.\n\nOnly GIF, JPEG (.jpeg or .jpg) and PNG formats display properly. However, due to a technical difficulty, GIF files won't display at all in the .pdf output.\n\nThe pictures will display at 400 points wide by 300 high. The team therefore advises you to save them with those proportions. Furthermore, no image file may be greater than 200Kb.";
	alert(message); }
