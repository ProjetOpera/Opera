function PopupCenter(pageURL,titre,w,h) {
	var gauche = (screen.width/2)-(w/2);
	var haut = (screen.height/2)-(h/2);
	var fenetre = window.open(pageURL,titre,'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+haut+', left='+gauche);
} 