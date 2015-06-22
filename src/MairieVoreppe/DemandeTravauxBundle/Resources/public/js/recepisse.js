$(document).ready(function(){

	/**
	*
	* Partie qui gère les différents type de réponse
	*
	*/
	$('#proto-reponse').on('click', function(){

		var prototypeDeChamps = $(this).find('option:selected').attr('data-prototype');

		// console.log(prototypeDeChamps);


        //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

		if($('#reponse li').length > 0)
			$('#reponse li').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);



        var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
        newLi.appendTo($('#reponse'));
	})


	/**
	*
	* Partie qui gère les emplacement du chantier
	*
	*/
	var prototypeDeChampsRO = $("table#list-emplacement-reseau-ouvrage").attr("data-prototype");

	// console.log(prototypeDeChampsRO);

	//On souhaite avoir deux ligne
	var nombreDeChamps = 2, i = 0;

	while(i < nombreDeChamps)
	{
        unChamp = prototypeDeChampsRO.replace(/__name__/g, i);

        // unChamp = unChamp.replace(/<label(.*)<\/label>/, "");


		// console.log(unChamp);

        var newTr = $("<tr id=RO_" + i +"></tr>");
		var containerHtml = $("<div></div>").html(unChamp);

		//Je recupère tout le block des champs : le champs et le <div> qui le contient (nécessaire puisqu'il est définit avec bootstrap)
		var inputReference = containerHtml.find('input[field="reference"]').parent();
		var inputEchelle = containerHtml.find('input[field="echelle"]').parent();
		var inputDateEdition = containerHtml.find('input[field="dateEdition"]').parent();
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

	/**
	*
	* Partie qui gère les différents type de rendez vous
	*
	*/
	$('#proto-rendez-vous').on('click', function(){

		var prototypeDeChamps = $(this).find('option:selected').attr('data-prototype');

		// console.log(prototypeDeChamps);


        //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

		if($('#rendez-vous p').length > 0)
			$('#rendez-vous p').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);


        var newLi = $('<p id="' + $(this).val() + '"></p>').html(ensembleDeChampConcret); 
        newLi.appendTo($('#rendez-vous'));
	})

});