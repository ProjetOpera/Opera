<?php 
/*
*
* Module SendMail : envoi d'un mail
* Ce module contient une seule fonction sendMail permettant d'envoyer un mail
*
*/
	// PRE-REQUIS: Renseigner la rubrique 'mail function' du fichier php.ini
	
/********************************************
* Fonction d'envoi d'un mail simple en HTML *
*********************************************/
function sendSimpleHtmlMail ($to, $cc, $bcc, $from, $subject, $body, $replyTo=null) {
	//----------------------------------------------- 
	//HEADERS DU MAIL 
	//----------------------------------------------- 
	$headers = "From: $from<>\n"; 
	$headers .= "Reply-To: $replyTo\n"; 
	if ($cc != "")
		$headers .= "Cc: $cc\n"; 
	if ($bcc != "")
		$headers .= "Bcc: $bcc\n"; 
	$headers .= "MIME-Version: 1.0\n"; 
	$headers .="Content-Type: text/html; charset=\"utf_8\"\n";
	$headers .='Content-Transfer-Encoding: 8bit';


	//----------------------------------------------- 
	//MESSAGE HTML 
	//----------------------------------------------- 
	$message = "<html> 
	<head> 
	<title>Titre</title> 
	</head> 
	<body>$body</body> 
	</html>\n\n"; 

	$res = mail($to, $subject, $message, $headers);
	return $res;
}

/****************************************************
* Fonction d'envoi d'un mail avec plusieurs partie  *
*	- message en HTML                               *
*	- Fichier joint                                 *
*****************************************************/

function sendMultiPartMail ($to, $cc, $bcc, $from, $subject, $htlmMsg=null, $replyTo=null, $joinFilesName=null, $joinFilesContent=null) {
     /*----------------------------------------------- 
     * Parametres d'entree de la fonction 
	 * -----------------------------------------------
	 * $to : Liste d'adreeses destinataires (les adresses sont separees par de virgule
	 * $cc : Liste des adresses en copie
	 * $from : Adresse de l'expediteur
	 * $subject : Objet du mail
	 * $htlmMsg : message a envoyer au format HTML
	 * $replyTo : Adresse pour la reponse a'expeteur (peut etre diffent de $from)
	 * $joinFilesName : au format $_FILES (voir $_FILE dans le manuel de PHP)
	 * $joinFilesContent : un tableau de contenu de fichier :
	 *                     - $joinFilesContent[xxx]['type'] = Type MIME du fichier
	 *                     - $joinFilesContent[xxx]['name'] = Nom du fichier
	 *                     - $joinFilesContent[xxx]['content'] = Contenu du fichier
	 *
    -------------------------------------------------*/
	//----------------------------------------------- 
	//GENERE LA FRONTIERE DU MAIL ENTRE TEXTE ET HTML 
	//----------------------------------------------- 
	$frontiere = "-----=" . md5(uniqid(mt_rand())); 

	//----------------------------------------------- 
	//HEADERS DU MAIL 
	//----------------------------------------------- 
	$headers = "From: $from<>\n"; 
	$headers .= "Reply-To: $replyTo\n"; 
	if ($cc != "")
		$headers .= "Cc: $cc\n"; 
	if ($bcc != "")
		$headers .= "Bcc: $bcc\n"; 
	$headers .= "MIME-Version: 1.0\n"; 
	$headers .= "Content-Type: multipart/mixed; boundary=\"$frontiere\"\n"; 

	$message = "This is a multi-part message in MIME format.\n\n"; 

	//----------------------------------------------- 
	//MESSAGE HTML (Format HTML entier)
	// $htmlMsg peut contenit :
	//	- Entete + Body
	//		<HTML>
	//			<HEAD>....</HEAD>
	//			<BODY>....</BODY>
	//		</HTML>
	//	- Ou seulement <Body>...</BODY>
	//----------------------------------------------- 
	
	if ($htlmMsg != null) {
		$htmlMsg = trim ($htmlMsg);
		//Si Le message ne contien pas d'entete HTML ==> Inserer l'entete HTML
		if (stripos ($htlmMsg, '<HTML>') === false) {
			$htlmMsg = "<html> 
			<head> 
			<meta http-equiv='content-type' content='text/html; charset=utf-8'>
			<title>titre</title> 
			</head> 
			<body>$htlmMsg</body> 
			</html>\n\n"; //Ne pas changer double-quote en simple-quot
		}

		$imgList = array();
		//-----------   Traiter le tag <img .. src="...">   ------------------
		/* preg_match_all('~<img.*?src=.([\/.a-z0-9:_-]+).*?>~si', $htlmMsg, $matches); */
		preg_match_all('~<img.*?src\s*=\s*["\']{1}([^\'"]+)["\']{1}.*>~si', $htlmMsg, $matches);
		foreach ($matches[1] as $img) {
			//Rechercher si le fichier image existe deja
			if (!in_array ($img, $imgList))
				$imgList[] = $img;
		}
		//-----------   Traiter le style "background-image: url('...')"   ------------------
		/* preg_match_all('~background.*?url.*?\(["\']([\/.a-z0-9:_-]+)["\'].*?\)~si', $htlmMsg, $matches); */
		preg_match_all('~background(?:-image)?\s*:\s*url\s*\(["\'\s]*([^\'"]+)["\'\s]*\)~si', $htlmMsg, $matches);
		foreach ($matches[1] as $img) {
			//Rechercher si le fichier image existe deja
			if (!in_array ($img, $imgList))
				$imgList[] = $img;
		}
		// $i = 0;
		$paths = array();

		foreach ((array)$imgList as $img) {
			if(stripos($img, "http://") == false) {
				$content_id = md5($img);
				$paths[$content_id]['path'] = $img;
				$htlmMsg = str_replace($img, "cid:$content_id", $htlmMsg);
				// $paths[$i++]['cid'] = $content_id;
			}
		}

		$message .= "--$frontiere\n";
		$message .= "Content-Type: text/html; charset=\"utf_8\"\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $htlmMsg."\n\n";

		foreach ((array)$paths as $content_id => $path) {
			$imagetype = substr(strrchr($path['path'], '.' ),1);
			$message_part = "";

			switch ($imagetype) {
			case 'png':
			case 'PNG':
				$message_part .= "Content-Type: image/png";
				break;
			case 'jpg':
			case 'jpeg':
			case 'JPG':
			case 'JPEG':
				$message_part .= "Content-Type: image/jpeg";
				break;
			case 'gif':
			case 'GIF':
				$message_part .= "Content-Type: image/gif";
				break;
			}

			$message_part .= "; file_name = \"{$path['path']}\"\n";
			$message_part .= 'Content-ID: <'.$content_id.">\n";
			$message_part .= "Content-Transfer-Encoding: base64\n";
			$message_part .= "Content-Disposition: inline; filename = \"".basename($path['path'])."\"\n\n";
			$message_part .= chunk_split(base64_encode(file_get_contents($path['path'])))."\n";
			$message .= "--$frontiere\n".$message_part."\n";
		}

	}

	// if (($joinFilesName != null) && ($joinFilesName != '')) {
	if (!empty($joinFilesName)) {
		$listFile = $joinFilesName;
	}

	// if (($joinFilesContent != null) && ($joinFilesContent != '')) {
	if (!empty($joinFilesContent)) {
		if (is_array ($listFile))
			$listFile = array_merge ($listFile, $joinFilesContent);
		else
			$listFile = $joinFilesContent;
	}

	foreach((array)$listFile as $oneFile)
	{
		$message_part = "Content-Type: ".$oneFile['type']."; name=\"".$oneFile['name']."\"\n";
		$message_part .="Content-Transfer-Encoding: base64\n";
		$message_part .="Content-Disposition: attachment; filename=\"".$oneFile['name']."\"\n\n";
		if (isset ($oneFile['content']))
			$message_part .= chunk_split(base64_encode($oneFile['content']))."\n";
		else
			$message_part .= chunk_split(base64_encode(file_get_contents($oneFile['tmp_name'])))."\n";
		$message .= "--$frontiere\n".$message_part."\n";
	}

	$message .= "--$frontiere--\n";
		
	$res = mail($to, $subject, $message, $headers);
	return $res;
}

/********************************************
* Fonction d'envoi d'un calendrier de Meeting  *
*********************************************/
function sendCalendarEntry ($to, $organizer, $location, $starDateAndHour, $endDateAndHour, $subject, $desc, $attendees, $rappel/* en minutes avant le debut de meeting */) {

	//Date de debut de meeting dans le Time zone courant
	$dateTimeDeb = new DateTime ($starDateAndHour);
	//Transformer en date-Heure UTC
	$dateTimeDeb->setTimezone(new DateTimeZone('UTC'));
	$startDate = $dateTimeDeb->format('Ymd');
	$startTime = $dateTimeDeb->format('Hi');

	//Date de fin de Meeting dans le Time zone courant
	$dateTimeFin = new DateTime ($endDateAndHour);
	//Transformer en date-Heure UTC
	$dateTimeFin->setTimezone(new DateTimeZone('UTC'));
	$endDate = $dateTimeFin->format('Ymd');
	$endTime = $dateTimeFin->format('Hi');

	$headers  = 'Content-Type:text/calendar; Content-Disposition: inline; charset=utf-8;\r\n';
	$headers .= 'Content-Type: text/plain; charset="utf-8"\r\n'; 
	// $headers .= "From: $from<>".($cc ? "\r\nCc: $cc" : "").'\r\n';

	$attendee = "";
	foreach ($attendees as $key => $oneAttendee)  {
		$attendee .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=FALSE;CN={$oneAttendee['name']}:MAILTO:{$oneAttendee['email']}\r\n";
	}

//Pour controle - DEBUT -
// $to .= ', chankresna.ea@rte-france.com';
// $attendee .= "ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=NON-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=FALSE;CN=EA Chankresna:MAILTO:chankresna.ea@rte-france.com\r\n";
//Pour controle - FIN -

	$message = "
	BEGIN:VCALENDAR\r\n
	VERSION:2.0\r\n
	PRODID:-//Deathstar-mailer//theforce/NONSGML v1.0//EN\r\n
	METHOD:REQUEST\r\n
	BEGIN:VEVENT\r\n
	UID:" . md5(uniqid(mt_rand(), true)) . "example.com\r\n
	DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\r\n
	DTSTART:{$startDate}T{$startTime}00Z\r\n
	DTEND:{$endDate}T{$endTime}00Z\r\n
	SUMMARY:$subject\r\n
	ORGANIZER;CN={$organizer['name']}:mailto:{$organizer['email']}\r\n
	LOCATION:$location\r\n
	DESCRIPTION:$desc\r\n
	$attendee
	BEGIN:VALARM\r\n
	TRIGGER:-PT{$rappel}M\r\n
	ACTION:DISPLAY\r\n
	DESCRIPTION:Reminder\r\n
	END:VALARM\r\n
	END:VEVENT\r\n
	END:VCALENDAR\r\n";

	$headers .= $message;

	$res = mail($to, $subject, $message, $headers);

	return $res;
}

?> 