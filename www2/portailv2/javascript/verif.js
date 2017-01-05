function verif_auth(formulaire) {
	alerte = "";
	var ck_username = /^[A-Za-z0-9_-]{1,20}$/;
	//var ck_password =  /^[A-Za-z0-9!@#$%^&\*()_]{6,20}$/;
	var login = formulaire.login.value;
	//var pw = formulaire.password.value;
	
	if (!ck_username.test(login)) {alerte += "- Login invalide -"; }
	//if (!ck_password.test(pw)) { alerte += "- Mot de Passe invalide -"; }
	
	
	if (alerte != "") { 
		document.getElementById("info").innerHTML = alerte;
		return false;
	}
	else return true; /*formulaire.submit();	*/
}
