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
        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , 0);

		if($('ul#reponse li').length > 0)
			$('ul#reponse li').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);



        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
        var newLi = $('<li></li>').html(ensembleDeChampConcret); 
        newLi.appendTo($('ul#reponse'));
	});

	// var prototypeDeChamps = $('#proto-reponse').find('option:eq(1)').attr('data-prototype');

 //    //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
 //    prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

 //     ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, "0");



 //        // var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
 //        var newLi = $('<li></li>').html(ensembleDeChampConcret); 
 //        newLi.appendTo($('ul#reponse'));

}

/**
*
* Fonction qui gère les emplacement du chantier
*
*/
function emplacementChantier()
{
	var prototypeDeChampsRO = $("table#list-emplacement-reseau-ouvrage").attr("data-prototype");
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
	* Partie qui gère les différents type de rendez vous
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

		if($('#rendez-vous section').length > 0)
			$('#rendez-vous section').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


        var newSection = $('<section></section>').html(ensembleDeChampConcret); 
        newSection.appendTo($('#rendez-vous'));
	});

	
	//Détection si la case n'est pas acoché afin de 
	$("#mairievoreppe_demandetravauxbundle_recepissedict_priseRendezVous").click( function(){
   		if($(this).is(':checked') == false ){
   			// alert("décoché");
   			$('#rendez-vous').empty();
			$("#mairievoreppe_demandetravauxbundle_recepissedict_priseRendezVous").prop('checked', false);
   		}
   		 

	});
}