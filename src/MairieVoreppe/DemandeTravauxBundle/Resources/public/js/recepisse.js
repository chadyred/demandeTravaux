$(document).ready(function(){

	/**
	*
	* Partie qui initialise les partie en javascript nécessaire
	*
	* La bibliothèque est en conflit avec bootstrap_js
	*/
	 // $('.datetimepicker').datepicker({
	 //               inline: true,
	 //               sideBySide: true
	 //           });

	
	typeReponse();
	emplacementChantier();
	typeRendezVous();



   		
});



/**
*
* Fonction qui gère les différents type de réponse
*
*/
function typeReponse()
{
	$('#proto-reponse').on('click', function(){

		var prototypeDeChamps = $(this).find('option:selected').attr('data-prototype');

		// console.log(prototypeDeChamps);


        //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

		if($('ul#reponse li').length > 0)
			$('ul#reponse li').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);



        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
        var newLi = $('<li></li>').html(ensembleDeChampConcret); 
        newLi.appendTo($('ul#reponse'));
	});

	/**
	*
	* Partie qui va créer l'entité qui correspond à l'édition
	*
	*/
	var serialisationReponse = $("select#proto-reponse").attr("data-reponse-prev");

	//Il vaut null et est inexistant dans le cadre d'une création
	if(serialisationReponse!= null)
	{
		var jsonToJavascriptObject = $.parseJSON(serialisationReponse);

		switch(jsonToJavascriptObject.reponse.class)
		{
			case "MairieVoreppe\\DemandeTravauxBundle\\Entity\\NonConcerne":
			{
				/**
				* Récupération et création de la sctructure
				*/
				var prototypeDeChamps = $("select option#mairievoreppe_demandetravauxbundle_nonconcerne").attr("data-prototype");
				var distance = jsonToJavascriptObject.reponse.distance_n_c;

				 //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
		        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

				if($('ul#reponse li').length > 0)
					$('ul#reponse li').remove();

		        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


		        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
		        var newLi = $('<li></li>').html(ensembleDeChampConcret); 

		        console.log("distance => " + distance);

				/**
				* Insertion des données
				*/
				newLi.find('input#mairievoreppe_demandetravauxbundle_recepissedict_reponse_0_distanceNC').val(distance);
				newLi.find('input#mairievoreppe_demandetravauxbundle_recepissedt_reponse_0_distanceNC').val(distance);

				/**
				* Affichage du formulaire
				*/ 
		        newLi.appendTo($('ul#reponse'));

		        break;
			}

			case "MairieVoreppe\\DemandeTravauxBundle\\Entity\\DemandeImprecise":
			{
				/**
				* Récupération et création de la sctructure
				*/
				var prototypeDeChamps = $("select option#mairievoreppe_demandetravauxbundle_demandeimprecise").attr("data-prototype");
				var description = jsonToJavascriptObject.reponse.description;

				 //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
		        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

				if($('ul#reponse li').length > 0)
					$('ul#reponse li').remove();

		        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


		        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
		        var newLi = $('<li></li>').html(ensembleDeChampConcret); 

		        // console.log("description => " + description);
		        
				/**
				* Insertion des données
				*/
				newLi.find('textarea#mairievoreppe_demandetravauxbundle_recepissedict_reponse_0_description').val(description);
				newLi.find('textarea#mairievoreppe_demandetravauxbundle_recepissedt_reponse_0_description').val(description);

				/**
				* Affichage du formulaire
				*/ 
		        newLi.appendTo($('ul#reponse'));

		        break;
			}

			case "MairieVoreppe\\DemandeTravauxBundle\\Entity\\Concerne":
			{
				/**
				* Récupération et création de la sctructure
				*/
				var prototypeDeChamps = $("select option#mairievoreppe_demandetravauxbundle_concerne").attr("data-prototype");
				var cat_roa = jsonToJavascriptObject.reponse.categorie_reseau_ouvrage;

				 //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
		        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

				if($('ul#reponse li').length > 0)
					$('ul#reponse li').remove();

		        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


		        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
		        var newLi = $('<li></li>').html(ensembleDeChampConcret); 

		        console.log("description => " + cat_roa);
		        
				/**
				* Insertion des données : ici on va récupérer les deux première lettre du toString qui est le code (solution trop dépendante
				* TODO : une solution moins dépendante. Le problème est qu'un type entity vise une entité dont les attributs de clase ne peuvent pas avoir d'attribut 
				* HTML...
				*/
				var inputCatRo;
				if(newLi.find("div#mairievoreppe_demandetravauxbundle_recepissedict_reponse_0_categorieReseauOuvrage input") != null)
					inputCatRo = newLi.find("div#mairievoreppe_demandetravauxbundle_recepissedict_reponse_0_categorieReseauOuvrage input");
				else
					if(newLi.find("div#mairievoreppe_demandetravauxbundle_recepissedt_reponse_0_categorieReseauOuvrage input") != null)
						inputCatRo = newLi.find("div#mairievoreppe_demandetravauxbundle_recepissedt_reponse_0_categorieReseauOuvrage input");

				$.each(inputCatRo, function(index, value){
						var labelTypeReseau = $(this).parent().text();

						var abreviation = $(this).parent().text().substr(0, 2);

						for(i = 0;i < cat_roa.length;i++)
						{					
						console.log(cat_roa[i].code + "==" + abreviation );
							if(cat_roa[i].code === abreviation)
							{
								// alert("trouve code => " + abreviation + "cat_roa =>" + cat_roa[i].code);
								$(this).prop('checked', "checked");
							}
						}

					});

				/**
				* Affichage du formulaire
				*/ 
		        newLi.appendTo($('ul#reponse'));

		        break;
			}
			default: 
			{
				alert("dans la switch");
				alert("pas de type de réponse identifiée");
				break;
			}

		}
	}

}



/**
*
* Fonction qui gère les emplacement du chantier
*
*/
function emplacementChantier()
{
	var prototypeDeChampsRO = $("table#list-emplacement-reseau-ouvrage").attr("prototype-reo");
	//Nécessaire lors de l'update
	var nbChampsROExistant= $("table#list-emplacement-reseau-ouvrage tbody tr").length;

	// console.log(prototypeDeChampsRO);

	//On souhaite avoir deux ligne
	var nombreDeChamps = 2, i = 0;

	while(i < nombreDeChamps - nbChampsROExistant)
	{
        unChamp = prototypeDeChampsRO.replace(/__name__/g, i);

        // unChamp = unChamp.replace(/<label(.*)<\/label>/, "");


		console.log(unChamp);

        var newTr = $('<tr id="RO_' + i + '"></tr>');
		var containerHtml = $("<div></div>").html(unChamp);

		//Je recupère tout le block des champs : le champs et le <div> qui le contient (nécessaire puisqu'il est définit avec bootstrap)
		var inputReference = containerHtml.find('input[field="reference"]').parent();
		var inputEchelle = containerHtml.find('input[field="echelle"]').parent();
		//Pour ce champ, la date est contenu dans un bloc avec l'id du champ placé dans le formType
		var inputDateEdition = containerHtml.find('div[field="dateEdition"]'); 
		var inputSensible = containerHtml.find('input[field="sensible"]').parent();
		var inputProfondeurReglMini = containerHtml.find('input[field="profondeurReglMini"]').parent();
		var inputMateriauxReseau = containerHtml.find('input[field="materiauxReseau"]').parent();

		//Je créé un td pour chaque information
		var tdReference = $("<td></td>").html(inputReference);
		var tdEchelle = $("<td></td>").html(inputEchelle);
		var tdDateEdition = $("<td></td>").html(inputDateEdition);
		var tdSensible = $("<td></td>").html(inputSensible);
		var tdProfondeurReglMini = $("<td></td>").html(inputProfondeurReglMini);
		var tdMateriauxReseau = $("<td></td>").html(inputMateriauxReseau);

		//Je met les TD dans la ligne nouvellement créé
		tdReference.appendTo(newTr);
		tdEchelle.appendTo(newTr);
		tdDateEdition.appendTo(newTr);
		tdSensible.appendTo(newTr);
		tdProfondeurReglMini.appendTo(newTr);
		tdMateriauxReseau.appendTo(newTr);

		//J'insère la ligne dans le corps du tableau
		newTr.appendTo($("table#list-emplacement-reseau-ouvrage tbody"));

		i++;
	}
}


/**
*
* Partie qui gère les différents type de rendez vous, ainsi que les prototypes liés au multiple prototype réalisé par l'infinitePolycolection
*
*/
function typeRendezVous()
{
	$('#proto-rendez-vous').on('click', function(){

		//On coche la case si un choix se fait
		$("#mairievoreppe_demandetravauxbundle_recepissedict_priseRendezVous").prop('checked', true);

		var prototypeDeChamps = $(this).find('option:selected').attr('data-prototype');

		// console.log(prototypeDeChamps);


        //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
        // prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

        //Je retire le label du début du prototype
        // prototypeDeChamps = prototypeDeChamps.replace(/<label(.*)<\/label>/ , "");

		if($('ul#rendez-vous li').length > 0)
			$('ul#rendez-vous li').remove();
 
        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


        var newLi = $('<li></li>').html(ensembleDeChampConcret); 
        newLi.appendTo($('#rendez-vous'));
	});

	
	//Détection si la case n'est pas acoché afin de 
	$("#mairievoreppe_demandetravauxbundle_recepissedict_priseRendezVous").click( function(){
   		if($(this).is(':checked') == false ){
   			// alert("décoché");
   			$('#rendez-vous').empty();
			$("#mairievoreppe_demandetravauxbundle_recepissedict_priseRendezVous").prop('checked', false);
   		}
   		 

	});

	/**
	*
	* Partie qui va créer l'entité qui correspond à l'édition
	*
	*/
	var serialisationRdv = $("select#proto-rendez-vous").attr("data-rendez-vous-prev");

	if(serialisationRdv != null)
	{
		var jsonToJavascriptObject = $.parseJSON(serialisationRdv);

		switch(jsonToJavascriptObject.rendez_vous.class)
		{
			case "MairieVoreppe\\DemandeTravauxBundle\\Entity\\CommunAccord":
			{
				/**
				* Récupération et création de la sctructure
				*/
				var prototypeDeChamps = $("select option#mairievoreppe_demandetravauxbundle_communaccord").attr("data-prototype");
				var dateRetenue = jsonToJavascriptObject.rendez_vous.date_retenue;
				//variable qui contient un tableau associatif des date heur et minute afin d'associer les bonnes informations aux bonnes listes.
				var dateFinal = dateStringToInputFormDate(dateRetenue);


				 //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
		        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

				if($('ul#rendez-vous li').length > 0)
					$('ul#rendez-vous li').remove();

		        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


		        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
		        var newLi = $('<li></li>').html(ensembleDeChampConcret); 

		        console.log(dateFinal);

				/**
				* Insertion des données
				*/
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_date_day').val(dateFinal.day);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_date_month').val(dateFinal.month);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_date_year').val(dateFinal.year);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_time_hour').val(dateFinal.hour);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_time_minute').val(dateFinal.minute);

				/**
				* Affichage du formulaire
				*/ 
		        newLi.appendTo($('ul#rendez-vous'));

		        break;
			}

			case "MairieVoreppe\\DemandeTravauxBundle\\Entity\\InitiativeDeclarant":
			{
				/**
				* Récupération et création de la sctructure
				*/
				var prototypeDeChamps = $("select option#mairievoreppe_demandetravauxbundle_initiativedeclarant").attr("data-prototype");
				var dateRetenue = jsonToJavascriptObject.rendez_vous.date_retenue;
				//variable qui contient un tableau associatif des date heur et minute afin d'associer les bonnes informations aux bonnes listes.
				var dateFinal = dateStringToInputFormDate(dateRetenue);


					 //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
		        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

				if($('ul#rendez-vous li').length > 0)
					$('ul#rendez-vous li').remove();

		        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


		        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
		        var newLi = $('<li></li>').html(ensembleDeChampConcret); 

		        
		        console.log(dateFinal);

				/**
				* Insertion des données
				*/
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_day').val(dateFinal.day);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_month').val(dateFinal.month);
				newLi.find('select#mairievoreppe_demandetravauxbundle_recepissedict_rendezVous_0_dateRetenue_year').val(dateFinal.year);


				/**
				* Affichage du formulaire
				*/ 
		        newLi.appendTo($('ul#rendez-vous'));

		        break;
			}
			
			default: 
			{
				alert("dans la switch");
				alert("pas de type de rendezVous identifiée");
				break;
			}

		}
	}
}


function dateStringToInputFormDate(date)
{

        var objectDate = new Date(date);
        var dateFinal = []

        //On récupère chaque élément
        var month = objectDate.getMonth() + 1;
        var day = objectDate.getDate();
        var year = objectDate.getFullYear();
        var hour = objectDate.getHours();
        var minute = objectDate.getMinutes();

        dateFinal = {'day' : day, 'month': month, 'year': year, 'hour':hour, 'minute':minute };

        return dateFinal;
}
