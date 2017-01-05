function ajaxAssocApp(id){
	var xhr_object = null; 
	 
	  if(window.XMLHttpRequest) // Firefox 
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
		else { // XMLHttpRequest non supporté par le navigateur 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		 
		xhr_object.open("POST", "include/groupesusers/association/ajaxAssocApp.php", true); 
			 
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4) {
				eval(xhr_object.responseText);
			}
		} 
						
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		var data = "id="+id; 
		xhr_object.send(data);
		return false; 
}





function ajaxAssocAppBdd(id_contact,checke,id_groupe){
	var xhr_object = null; 
	 
	  if(window.XMLHttpRequest) // Firefox 
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
		else { // XMLHttpRequest non supporté par le navigateur 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		 
		xhr_object.open("POST", "include/groupesusers/association/ajaxAssocApp.php", true); 
			 
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4) {
				//eval(xhr_object.responseText);
			}
		} 
						
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		var data = "id_contact="+id_contact+"&checke="+checke+"&id_groupe="+id_groupe; 
		xhr_object.send(data);
		return false; 
}
