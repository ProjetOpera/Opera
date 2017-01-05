/****************************
** BOUTON SANS AFFECTATION **
*****************************/
function affect_ajax(f,z,sens,SelectActive,m){
		var xhr_object = null; 
	     
	  if(window.XMLHttpRequest) // Firefox 
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
		else { // XMLHttpRequest non supporté par le navigateur 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		 
		xhr_object.open("POST", "functions/robot_coffre_ajax.php", true); 
		     
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4) {
				eval(xhr_object.responseText);
	    }
		} 
		
		if (sens == "right")	var robot = f.sel_liste1.value;
		if (sens == "left")		var robot = f.sel_liste2.value;
		
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		var data = "robot="+robot+"&zone="+z+"&sens="+sens+"&active="+SelectActive+"&m="+m; 
		xhr_object.send(data);
		return false; 
	}


/***********************
** BOUTON AFFECTATION **
************************/
function affect_ajax2(f,z,sens,SelectActive,m){
		var xhr_object = null; 
	     
	  if(window.XMLHttpRequest) // Firefox 
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
		else { // XMLHttpRequest non supporté par le navigateur 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		 
		xhr_object.open("POST", "functions/dragndrop_ajax2.php", true); 
		     
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4) {
				eval(xhr_object.responseText);
	    }
		} 
		
		if (sens == "right")	var origin = f.sel_liste1.value;
		if (sens == "left")		var origin = f.sel_liste2.value;
		
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		var data = "origin="+origin+"&zone="+z+"&sens="+sens+"&active="+SelectActive+"&type="+m; 
		xhr_object.send(data);
		return false; 
	}
