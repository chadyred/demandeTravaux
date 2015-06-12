$(document).ready(function(){

	$('#proto-reponse').on('click', function(){

		var prototypeDeChamps = $(this).find('option:selected').attr('data-prototype');

		console.log(prototypeDeChamps);


        //Je choisie de ne rien mettre en label globale, le type étant visible dans la liste
        prototypeDeChamps = prototypeDeChamps.replace(/__name__label__/ , "");

		if($('#reponse li').length > 0)
			$('#reponse li').remove();

        ensembleDeChampConcret = prototypeDeChamps.replace(/__name__/g, 0);



        var newLi = $('<li id="' + $(this).val() + '"></li>').html(ensembleDeChampConcret); 
        newLi.appendTo($('#reponse'));
	})



});