$(document).ready(function(){

	var container = $('<div>');
	var videoMuse = $('<iframe width="560" height="315" src="https://www.youtube.com/embed/I5sJhSNUkwQ?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');

	$(".destroy-me").click(function(){
	  $('.container-fluid').hide("slow");
	  $('footer').hide("slow");
      container.append(videoMuse);
      container.attr('id', "container");
      $('body').append(container);
      container.css({"display":"inline-block", 
	      "position":"absolute",
	      "right":"50%"});
      container.show("slow");

	//Au bout de 10 seconde, je retire la vidéo et je réafiiche le container
	  setTimeout(function(){
	  	container.hide("slow");
	  	container.remove();
	  	$('.container-fluid').show("slow");
	  	$('footer').show("slow");
	  }, 10000);
	});

});


