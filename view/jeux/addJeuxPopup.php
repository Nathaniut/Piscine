<div class="infos">
	<h2>Ajouter un jeu</h2>
<form method="post">
	<fieldset class="form-infos">
	    <label>Libelle Jeu:
	    	<input type="text" placeholder="Nom jeu" name="libelleJeu" required /></label>

		<label>Prototype:
			<input type="checkbox" name="estPrototype" /></label>
			
		<label>Surdimenssioné:
			<input type="checkbox" name="estSurdi" /></label>

		<label>Payer frais:
			<input type="checkbox" name="payerFrais" /></label>
	
		<label>Type jeux:
			<select id="typeJeu" name="numTypeJeu">
	       	</select>
   		</label>

   		<label>Nombre d'exemplaire:
		<input type="number" placeholder="Nombre d'exemplaire" name="nbExemplaire" required /></label>
   		<input type="hidden" name="popupJS" value="true" />
        
        <input class="edit-button-save" type="button" name="addJeu" value="Enregistrer" />
    </fieldset>
</form>
</div>

<script>

	//Requete AJAX pour ajouter un editeur et récupérer son id et l'ajouter au select
	$("input[name='addJeu']").click(function(){
		var libelleJeu = $("input[name='libelleJeu']").val();
		var estPrototype = $("input[name='estPrototype']:checked").val();		
		var estSurdi = $("input[name='estSurdi']:checked").val();
		var payerFrais = $("input[name='payerFrais']:checked").val();
		var numType = $("#typeJeu option:selected").val();
		var nbExemplaire = $("input[name='nbExemplaire']").val();
		var numEditeur = $("#editeur option:selected").val();
		var popupJS = $("input[name='popupJS']").val();

		$.post('index.php?controller=jeux&action=registerJeux',
		    {
		    	libelleJeu,
		    	estPrototype,
		    	estSurdi,
		    	payerFrais,
		    	numType,
		    	nbExemplaire,
		    	numEditeur,
		    	popupJS
		    }, function(data) {
		       	var div = document.getElementById("newJeu");
				div.innerHTML = "Jeu ajouté !";
		});
	});

	//On affiche la popup pour ajouter un editeur
	function popupJeu(){
		$("#newJeu").dialog({
			width: 1000,			
       		closeOnEscape: false,
       		 open: function(event, ui) {  $(".ui-dialog-titlebar-close", $(this).parent()).hide() },
			buttons: [
	            {
	                text: "fermer",
	                click: function () {
	                	$.ajax({
						      type: "GET",
						      url: "view/jeux/addJeuxPopup.php"
						   }).done(function(html){
						      $('#newJeu').html(html);
						});
	                    $(this).dialog("close");
	                }
	            }
	        ]
		});
	}

	//on récupère la liste des types
	$.ajax({
		type: "GET",
		url: "index.php?controller=type&action=getListeType"
		}).done(function(html){
			 $.each( JSON.parse(html), function( key, val ) {
			 	$("select[name='numTypeJeu']").append($('<option>', {
				    value: key,
				    text: val
				}));
			 })
		});

</script>