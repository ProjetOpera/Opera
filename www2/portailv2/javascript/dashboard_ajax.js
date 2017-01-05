/*****************************
** REMPLISSAGE POPUP JQUERY **
******************************/
function dashboard_popup_ajax(t,val1){
		var xhr_object = null; 
	     
	  if(window.XMLHttpRequest) // Firefox 
			xhr_object = new XMLHttpRequest(); 
		else if(window.ActiveXObject) // Internet Explorer 
			xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
		else { // XMLHttpRequest non supporté par le navigateur 
			alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
			return; 
		} 
		 
		xhr_object.open("POST", "functions/dashboard_ajax.php", true); 
		     
		xhr_object.onreadystatechange = function() { 
			if(xhr_object.readyState == 4) {
				eval(xhr_object.responseText);
	    }
		} 
		
				
		xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
		var data = "type="+t+"&val1="+val1; 
		xhr_object.send(data);
		return false; 
	}
