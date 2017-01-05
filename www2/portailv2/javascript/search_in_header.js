
	// Pour la recherche d'un utilisateur, d'un netbios ou d'une application
	$(function() {
		var societe;
		$.ajax({
			async: false,
			type: "POST",
			url: "../../portailv2/include/search_in_header.php?action=getSocieteContact",
			dataType: "json",
			success: function(data, textStatus, jqXHR) {
				societe = data["nom_societe"];
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert ("ERREUR :"+jqXHR["responseText"]);
				societe = "";
			}
		});

		if (societe == "ATOS") {
			$.getScript('/portailv2/javascript/jquery.ui.autocomplete.html.js');
			// Creer la zone saisie de recherche
			$("#session").append('<span id="span_search_in_header"></span>');
			$("#span_search_in_header").css("float", "right")
									   .css("margin-top", "-1px")
									   .css("margin-right", "20px")
									   .css("background-color", "white")
									   .css("border-radius", "7px")
									   .html('<input type="text" id="input_search_in_header" size="40" style="margin-left:10px; border:none; background-color:white; border-radius:7px;" title="Rechercher utilisateur" placeholder="Rechercher"></input>');

			// Fonction autocomplette pour les recherches
			$('#input_search_in_header').autocomplete({
				source: "../../portailv2/include/search_in_header.php?action=autocomplete",
				minLength: 2,
				html: true, // optional (jquery.ui.autocomplete.html.js required)
				select: function(event, ui) {
					var val_recherchee = ui.item.value;
					$('#input_search_in_header').val(ui.item.value);
					$.ajax({
						async: false,
						type: "POST",
						url: "../../portailv2/include/search_in_header.php?action=recherche&id="+ui.item.id,
						dataType: "html",
						success: function(data, textStatus, jqXHR) {
							setTimeout(function(){
							dialog = $("#DialogAfficheContact").dialog({
								title: "Information de l'utilisateur " + val_recherchee,
								height: "auto",
								width: "auto",
								// position: { my: "left top", at: "right bottom", of: $("#DialogAfficheContact")},
								modal: true,
								closeOnEscape: true,
								draggable: true,
								resizable: false,
								buttons:[
											{text: 'Quitter',
											 class: 'buttonQuitClass',
											 click: function () {$(this).dialog('close')}},
								],
								close: function () {
									$('#input_search_in_header').val("");
								}
							});
							dialog.prev(".ui-dialog-titlebar").css("background", "#0066A1").css("border", "1px solid #0066A1");
							$(".buttonQuitClass").css("color", "#0066A1");

							$("#DialogAfficheContact").html(data);
							}, 100);
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert ("ERREUR :"+jqXHR["responseText"]);
							res = false;
						}
					});
				},
			});
		}
	});

