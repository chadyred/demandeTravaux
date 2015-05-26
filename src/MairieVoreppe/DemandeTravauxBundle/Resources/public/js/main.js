/**
* Cette variable contient l'ensemble des des champs autocomplete auquel sera rattaché les instance d'autocomplete
* doit être accéssible dans le 'ready' puis dans les fonctions. Son scope doit être au plus large
*/

var autocompletesWraps = new Array();

$(document).ready(function(){
    

     /**
      * 
      * Fenêtre pop-up qui permet de choisir son service s'il y en a plusieurs
      * 
      */
     if($('.modal') !== undefined)
     {
        $('.modal').modal({         
           backdrop: 'static',
           keyboard: false
           });
          
        $('.modal').modal('show');
     }

    /*********************
     * 
     *      Permet de remplir le numéro de téléservice similaire dans une procédure de dt dict lié si la case est coché parce qu'elle est lié
     *      
     ********************/
    
    $('#mairievoreppe_demandetravauxbundle_dtdict_dt_numeroTeleservice').change(function() {
         //alert( "Handler for .change() called." );        
        //alert( "Case coché." );
        var numService = $('#mairievoreppe_demandetravauxbundle_dtdict_dt_numeroTeleservice').val();
        $('#mairievoreppe_demandetravauxbundle_dtdict_numeroTeleservice').val(numService);
    }); 
        
    $('#mairievoreppe_demandetravauxbundle_dtdict_dtDictCommune').change(function() {
            
        //alert( "Case coché." );
        var numService = $('#mairievoreppe_demandetravauxbundle_dtdict_dt_numeroTeleservice').val();
        $('#mairievoreppe_demandetravauxbundle_dtdict_numeroTeleservice').val(numService);  
             
    });
    
    /**********************************************************************
     * 
     * Gestion des adresse et des autocomplete
     * 
     **************************************hot******************************/
      //On vérifie que la liste existe, sans quoi la fonction n'a pas lieu d'exister
      if($('#adresse-fields-list').length !== 0)
      {
     
          
        //On initialise un numéro d'instance d'ensemble d'adresse
        var numInstance= 0;
        
        
          
        //Je parcours l'ensemble de mes instances de liste d'adresse comportant un ensemble d'adresse chacune
        $.each( $('[id=adresse-fields-list]'), function() {
        //J'indique le nombre d'adresse que je veut au départ
            gestionPrototypeAdresse($(this),numInstance, 1);
            numInstance++;
          });
       
        
      }
      else
      {
        initializeMonoAdresse();
      }
      /**
       * Initialisation de l'ajout de contact urgent au click
       */
      if($('#contact-urgent-fields-list').length !== 0)
      {          
           //On initialise un numéro d'instance d'ensemble d'adresse
        var numInstance= 0;
        
      
          
        //Je parcours l'ensemble de mes instances de liste d'adresse comportant un ensemble d'adresse chacune
        $.each( $('[id=contact-urgent-fields-list]'), function() {
            
        //J'indique le nombre d'adresse que je veut au départ
            ajouterContactUrgent($(this),numInstance);
            numInstance++;
          });
      }
      
      /*********************************************************
       * 
       * Gestion du click sur la récupération des information de la DT à mettre dans la DICT
       * 
       */
      
      //On commence par caché l'image de chargement
      $('.image-loading-dt-dict img').hide();
      
      
      $('#recuperer-info-dt').click(function(){
       
       remplirDtDictInformationBase();
       remplirDtDictAdresse();
       remplirDtDictContactUrgent();
      });

      /************************************************
      *
      * Gestion au click de la récupération de la DICT à laquel on désire lié une DT
      *
      *********************************************/
      $('#recup-dt').click(function(){
        remplirDictLieeDtInformationBase();
        remplirDictLieDtAdresse();
        remplirDtDictLieContactUrgent();
      });
      
});


/*******************************************************
 * 
 *      Fonction qui permet de gérer les adresse multiple des différents travaux.
 *  
 ****************************************/
  // J'indique l'instance du prototype corespondant, sont index, ainsi que le nombre de champs obligatoire
function gestionPrototypeAdresse(instance, index, nbreDeChampsAdresse)
{    
       
      /******************************
       * 
       *      Gestion de l'insertion des adresses obligatoire
       * 
       ****************************************/
    
      
      //Je récupère chaque élément de la liste
      var listeAdresseElmt = instance.find('li');      

      // garde une trace du nombre d'adresse qui ont été affichés
      var adresseCount = listeAdresseElmt.length;

      //Je récupère le prototype afin de créer un champs d'image
      var prototypeDeChamps = instance.attr('data-prototype');
      
      
    /*************************************
     * 
     * Je créer deux champs en remplcant la partie "__name__" avec un numéro unique 
     * de champs au sein du 'name' du formulaire
     * Au final le name ressemblera à ceci name="adresse[dt][adressesTravaux][2]"
     * initialisation de I qui permettra de suivre la I instance de d'autocomplete présent
     * 
     ******************************************/ 
     var i = 0;
     var j = adresseCount;

     //Tout les autocompletes au sein d'une instance de prototype déjà existant sont à initialiser : i aura pour valeur l'instance suivante, on peut alors continuer
     //Closest permet de prendre l'instance li la plus proche parmis les noeuds parents
     $.each(instance.find('input[autocomplete]').closest('li'), function() {
        //J'indique le nombre d'adresse que je veut au départ     
     
        //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
        //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
        var nombreAleatoire = genererNombreAleatoire();
        
         $(this).attr("id" ,"adresse_" + nombreAleatoire + '_' + adresseCount + '_' + index);
         autocompletesWraps.push("adresse_" + nombreAleatoire + '_' + adresseCount + '_' + index);
         i++;
       });
      
      //On vérifie s'il n'y pas moins de champs que ceux que l'on a déjà et que l'on veux au départ, si c'est le cas ils seront créés.
      //ceci permet d'indiquer un nombre de champs minimale( on ne prend pas i, le nombre de champs est plus viable)
      while(j < nbreDeChampsAdresse)
      {
        
        unChamp = prototypeDeChamps.replace(/__name__/g, i);
              
        /**
         * On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink())
         * On réalise cela ici, car il s'agit de précréer les champs obligatoire
         */
        unChamp = unChamp.replace(/<div><button type="submit"(.*)<\/button><\/div>/ , "");
        
        //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
        //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
        var nombreAleatoire = genererNombreAleatoire();
        
        // On créer un nouvelle élément de la lsite puis on ajoute ce dernier à la liste. Son id sera le I champs combiner avec la I instance d'une liste
        var newLi = jQuery('<li id="adresse_'+ nombreAleatoire +'_' + adresseCount + '_' + index + '"></li>').html(unChamp);        
        autocompletesWraps.push("adresse_" + nombreAleatoire + '_' + adresseCount + '_' + index);
                 

        newLi.appendTo(instance);

        //On va récupérer le label nouvellement ajouter afin de personnaliser son texte
        label = $('label[for="adresse_'+ nombreAleatoire +'_' + adresseCount + '_' + index + '"]');        
        label.text("Adresse n°" + (i + 1) + ": ");
          

        j++;
          
      }
      
      
      // On initailize les champs obligatoire à créer
      initializeMutliAdresse();

       /******************************
        * 
        *   Gestion de l'insertion des autres adresses pour un travaux, toujours en se basant sur une instance
        * 
        ****************************************/
    
        //Au click sur le bouton précédant l'instance en cours qui permet d'ajouter une adresse
        instance.prev('#ajouter-adresse').click(function() {

             // garde une trace du nombre d'adresse qui ont été affichés
            var adresseCount = instance.find('li').length;
            
            // parcourt le template prototype
            var newWidget = instance.attr('data-prototype');
            
            //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
            newWidget = newWidget.replace(/<button type="submit"(.*)<\/button><\/div>/ , "");
            
            // console.log(newWidget);
            // remplace les "__name__" utilisés dans l'id et le nom du prototype
            // par un nombre unique pour chaque periode d'exercice
            // le nom de l'attribut final ressemblera à name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, adresseCount);
            adresseCount++;
            

            //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
            //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
            var nombreAleatoire = genererNombreAleatoire();
            
            // créer une nouvelle liste d'éléments et l'ajoute à notre liste
            var newLi = jQuery('<li id="adresse_'+ nombreAleatoire +'_' + adresseCount + '_' + index + '"></li>').html(newWidget);
            autocompletesWraps.push("adresse_" + nombreAleatoire + '_' + adresseCount + '_' + index);
            
            // console.log(autocompletesWraps);
            
            addDeleteLink(newLi);
            newLi.appendTo(instance);
            
            //Permet de créer l'instance d'autocomplete de google place du champ ajouté via le prototype
            initializeMutliAdresse();

            return false;
        });          
           
        
}

// La fonction qui ajoute un lien de suppression d'une catégorie
function addDeleteLink(prototype) {
  // Création du lien
  var deleteLink = jQuery('<a href="#" class="btn btn-danger">Supprimer</a>');

  // Ajout du lien
  prototype.append(deleteLink);

  // Ajout du listener sur le clic du lien
  deleteLink.click(function(e) {
    prototype.remove();
    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
    return false;
  });
 }


// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

//Variable qui contiendra l'ensemble des instance de recherche d'autocompletion
var autocompleteMulti = new Array();
var placeSearch;
var autocomplete;

var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  postal_code: 'short_name'
};

function initializeMutliAdresse() {
    
    // console.log(autocompletesWraps);
    // console.log("Initialise multi : tableau lu !");
    $.each(autocompletesWraps, function(index, name) {
    // Create the autocomplete object, restricting the search
    // to geographical location types et les entreprise, tel que la mairie avec establishment.
    //Ceci est nécessaire afin que les instance existante ne soit pas recréé, et que tout soit refait, ce qui a fixé un bug de value undefined
    
    if(autocompleteMulti[name] === undefined)
    {
        // console.log("Pas d'instance d'autocomplete pour " + name);
        autocompleteMulti[name] = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */($('#' + name + ' input[autocomplete]')[0]),
            { types: ['geocode', 'establishment'] });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocompleteMulti[name], 'place_changed', function() {
          fillInAddress(name);
         });
     }
     else
     {         
            // console.log("Il existe une instance d'autocomplete pour " + name);
     }
  });
}

function initializeMonoAdresse() {
    // Create the autocomplete object, restricting the search
    // to geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */($('input[autocomplete]')[0]),
        { types: ['geocode', 'establishment'] });
    // When the user selects an address from the dropdown,
    // populate the address fields in the form.
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      fillInAddressMono();
     });
}



// [START region_fillform]
function fillInAddress(name) {
  // Get the place details from the autocomplete object.
  var place = autocompleteMulti[name].getPlace();
  for (var component in componentForm) { 
    $('#' + name + ' input[' + component + ']').val('');
    $('#' + name + ' input[' + component + ']').prop('disabled', false);
  }

  /*******
  *Gestion des Lieu dit dont l'adresse doit être dans la partie Lieu dit. Certaine ont un numéro non pris en compte, alors que 
  * d'autre si. Il n'est pas présente dans le tableau retourner des information sur l'adresse. 
  * Les BP ne sont pas géré
  */

  //On vide le lieu dit 

  $('#' + name + ' input[lieuDit]').val('');
  $('#' + name + ' input[lieuDit]').prop('disabled', false);

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {

    var addressType = place.address_components[i].types[0];

      if (componentForm[addressType]) 
      {
          
          if(place.address_components[i][componentForm[addressType]] !== undefined)
          {
                var val = place.address_components[i][componentForm[addressType]];

                if(addressType == "route" && estLieuDit(val))
                {
                  $('#' + name + ' input[lieuDit]').val(val);
                }
                else
                {
                  $('#' + name + ' input[' + addressType + ']').val(val);
                }
         }
    }
  }
}

// [START region_fillform]
function fillInAddressMono() {
  // Get the place details from the autocomplete object.
  var place = autocomplete.getPlace();
  for (var component in componentForm) { 
    $('input[' + component + ']').val('');
    $('input[' + component + ']').prop('disabled', false);
  }

  /*******
  *Gestion des Lieu dit dont l'adresse doit être dans la partie Lieu dit. Certaine ont un numéro non pris en compte, alors que 
  * d'autre si. Il n'est pas présente dans le tableau retourner des information sur l'adresse. 
  * Les BP ne sont pas géré
  */

  //On vide le lieu dit 

  $('input[lieuDit]').val('');
  $('input[lieuDit]').prop('disabled', false);

  // Get each component of the address from the place details
  // and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {

    var addressType = place.address_components[i].types[0];

      if (componentForm[addressType]) 
      {
          if(place.address_components[i][componentForm[addressType]] !== undefined)
          {
                var val = place.address_components[i][componentForm[addressType]];

                if(addressType == "route" && estLieuDit(val))
                {
                  $('input[lieuDit]').val(val);
                }
                else
                {
                  $('input[' + addressType + ']').val(val);
                }
          }
    }
  }
}
// [END region_fillform]

        $('.image-loading-dt-dict img').hide();
// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = new google.maps.LatLng(
          position.coords.latitude, position.coords.longitude);
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

/**
 * Fonction qui permet de savoir si on est en présence d'une adresse ou non
 * 
 * @param {type} adresse
 * @returns {Boolean}
 */
function estLieuDit(adresse)
{
  var estUnLieudit = false;
  
  if(adresse.substring(0, 8) == "Lieu dit")
  {
    estUnLieudit = true;
  }
  
  return estUnLieudit;
}

/**
 * Fonction qui me permet d'initialiser la fonction au click qui me permet d'ajouter un contact urgent
 * 
 * @returns {undefined}
 */
function ajouterContactUrgent(instance, index)
{
      /******************************
       * 
       *      Gestion de l'insertion des adresses obligatoire
       * 
       ****************************************/
    
      
      //Je récupère chaque élément de la liste
      var listeContactUrgentElmt = instance.find('li');      

      var contactUrgentCount = listeContactUrgentElmt.length;

      
      
    /*************************************
     * 
     * Je créer deux champs en remplcant la partie "__name__" avec un numéro unique 
     * de champs au sein du 'name' du formulaire
     * Au final le name ressemblera à ceci name="adresse[dt][contactUrgent][2]"
     * 
     ******************************************/ 
     
       
       /******************************
        * 
        *   Gestion de l'insertion des autres adresses pour un travaux, toujours en se basant sur une instance
        * 
        ****************************************/
    
        //Au click sur le bouton précédant l'instance en cours qui permet d'ajouter une adresse
        instance.prev('#ajouter-contact-urgent').click(function() {
                // garde une trace du nombre d'adresse qui ont été affichés
               var contactUrgentCount = instance.find('li').length;

               // parcourt le template prototype
               var newWidget = instance.attr('data-prototype');
                
                
                // remplace les "__name__" utilisés dans l'id et le nom du prototype
                // par un nombre unique pour chaque periode d'exercice
                // le nom de l'attribut final ressemblera à name="contact[emails][2]"
                newWidget = newWidget.replace(/__name__/g, contactUrgentCount);
               
               //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
                newWidget = newWidget.replace(/<div><button type="submit"(.*)<\/button><\/div>/ , "");
                contactUrgentCount++;
                
                // créer une nouvelle liste d'éléments et l'ajoute à notre liste
                var newLi = $('<li id="contact_urgent_' + contactUrgentCount + '_' + index + '"></li>').html(newWidget);
                addDeleteLink(newLi);
                newLi.appendTo(instance);
                
                return false;
            });            
           
}

/**
 * Fonction qui retour un objet javascript à partir d'un tableau serealisé en jSon
 * @param {type} formulaire
 * @returns {Array|serializeObject@pro;value|String}
 */
function serializeObject(formulaire)
{
    var o = {};
    var a = formulaire.serializeArray();
    $.each(formulaire, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    
    return o;
}

/**
 * Fonction qui va permettre de remplir les champs de la DICT lorsque l'on a ceux sur la DT
 * 
 */
function remplirDtDictInformationBase()
{
        var form = $('form[name=mairievoreppe_demandetravauxbundle_dtdict]');
        var inputs = form.find('#partie-dt .information-base input, #partie-dt .information-base textarea');
        var select = form.find('#partie-dt .information-base select');
        
        inputs.each(function () {
            if($(this).val() !== '')
            {
               var valeur = $(this).val();
               var idSource = $(this).attr('id');
               var idCible =  idSource.replace(/_dt_/, "_");
               $('#' + idCible).val(valeur);
                   
            }
        });
        
        //Je ne parcours pas les selects volontairement: seul le premier sera pris en compte. EN effet, le maire d'oeuvre et d'ouvrage étant différent
        // c'est à l'utilisateur de les définirs dans chacun des cas
        var valueOptionSelected = select.find(':selected').val();
        var idSource = select.attr('id');
        var idCible =  idSource.replace(/_dt_/, "_");
        $('#' + idCible).val(valueOptionSelected);   
        
        
}




function remplirDtDictAdresse()
{       
        
        // La première adresse obligatoire, cependant sont contenu sera remplacer. Il en va de même pour celles qui sont déjà présente. On ne peut pas les 
        //supprimer simplement du DOM. Il faudrais les remove en temps qu'entité. Autrement dit, on n'efface pas les existante. Leur suppression se fera au clique sur supprimer.
        $('#partie-dict ul[id=adresse-fields-list] li').not(':first, .dict-existant').remove();
        
        
        //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
        var nombreAdresseDt = $('#partie-dt ul[id=adresse-fields-list]').find('li').length;
        var nombreAdresseDict = $('#partie-dict ul[id=adresse-fields-list]').find('li').length;
        
        /**
         * On supprime les instance d'autocomplete étant dans l'intance 1, c'est à dire dans la partie DICT
         */
        for(i = autocompletesWraps.length - 1; i >= 0; i--) {
                autocompletesWraps[i] = autocompletesWraps[i].replace(/adresse(_(.*)_[\d]_1)/,"");
                if (autocompletesWraps[i] === "") {
                    autocompletesWraps.splice(i,1);
                }        
            
        }
        
        // console.log("Après suppression : autocompletesWraps => " + autocompletesWraps);
         /******
          * 
          *     Création des prototypes d'adresse
          * 
          */
         //On recréé juste ce qu'il faut d'adresse avec le prototype de DICT, sans jamais remplacer la première
        for(i=nombreAdresseDict; i < nombreAdresseDt;i++)
        {
           //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
            var nombreAdresseDict =  $('#partie-dict ul[id=adresse-fields-list]').find('li').length;
            
            // parcourt le template prototype
            var newWidget = $('#partie-dict ul[id=adresse-fields-list]').attr('data-prototype');
            
            //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
            newWidget = newWidget.replace(/<button type="submit"(.*)<\/button><\/div>/ , "");
            
            // console.log(newWidget);
            // remplace les "__name__" utilisés dans l'id et le nom du prototype
            // par un nombre unique pour chaque periode d'exercice
            // le nom de l'attribut final ressemblera à name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, nombreAdresseDict);
            nombreAdresseDict++;
            
            
            
            //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
            //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
            var nombreAleatoire = genererNombreAleatoire();
        
            // créer une nouvelle liste d'éléments et l'ajoute à notre liste qui est la deuxième liste d'adresse (les adresses de la dict) dont l'index vaux 1
            var newLi = jQuery('<li id="adresse_'+ nombreAleatoire +'_' + nombreAdresseDict + '_' + 1 + '"></li>').html(newWidget);
            autocompletesWraps.push("adresse_" + nombreAleatoire +"_" + nombreAdresseDict + "_" + 1);
            
            // console.log(autocompletesWraps);
            
            addDeleteLink(newLi);
            newLi.appendTo($('#partie-dict ul[id=adresse-fields-list]'));
            

        }
        
        
        initializeMutliAdresse();
            
        //Permet de créer l'instance d'autocomplete de google place du champ ajouté via le prototype
        // console.log("Nouvelle initialisation : autocompletesWraps => " + autocompletesWraps);
        var form = $('form[name=mairievoreppe_demandetravauxbundle_dtdict]');
        var inputs = form.find('#partie-dt ul[id=adresse-fields-list] li input');
        
        //On affiche l'image de chargement avant le setTimeout
       $("#corps").animate({height: 'toggle'},2000);
       $('.image-loading-dt-dict img').show();
       
                  
        setTimeout(function(){
            inputs.each(function () {
                if($(this).val() !== '')
                {
                   var valeur = $(this).val();
                   var idSource = $(this).attr('id');
                   var idCible =  idSource.replace(/_dt_/, "_");
                   $('#' + idCible).val(valeur);                   
                }
            });

            //Puis on l'enève une fois que tout les traitements sont terminés
             $('.image-loading-dt-dict img').hide();
             $("#corps").animate({height: 'toggle'},500);
        ;}, 1000);
        
        
        return false;        
        
}

/**
 * Fonction qui va me permettre de remplir mes CU
 */

function remplirDtDictContactUrgent()
{
    
        // On ne peut pas supprimer les contact urgents existant au seind 'une DICT (simplement du DOM) 
        // Il faudrais les remove en temps qu'entité. Autrement dit, on n'efface pas les existante. Leur suppression se fera au clique sur supprimer.
        $('#partie-dict ul[id=contact-urgent-fields-list] li').not('.dict-existant').remove();
        
        
        //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
        var nombreCuDt = $('#partie-dt ul[id=contact-urgent-fields-list]').find('li').length;
        var nombreCuDict = $('#partie-dict ul[id=contact-urgent-fields-list]').find('li').length;
        
        
        // console.log("Après suppression : autocompletesWraps => " + autocompletesWraps);
         /******
          * 
          *     Création des prototypes d'adresse
          * 
          */
         //On recréé juste ce qu'il faut de cu avec le prototype de DICT, sans jamais remplacer la première
        for(i=nombreCuDict; i < nombreCuDt;i++)
        {
           //On récupère le nombre de contactact urgent du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
            var nombreCuDict =  $('#partie-dict ul[id=contact-urgent-fields-list]').find('li').length;
            
            // parcourt le template prototype
            var newWidget = $('#partie-dict ul[id=contact-urgent-fields-list]').attr('data-prototype');
            
            //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
            newWidget = newWidget.replace(/<button type="submit"(.*)<\/button><\/div>/ , "");
            
            // console.log(newWidget);
            // remplace les "__name__" utilisés dans l'id et le nom du prototype
            // par un nombre unique pour chaque periode d'exercice
            // le nom de l'attribut final ressemblera à name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, nombreCuDict);
            nombreCuDict++;
            
            
            
            //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
            //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
            var nombreAleatoire = genererNombreAleatoire();
        
            // créer une nouvelle liste d'éléments et l'ajoute à notre liste qui est la deuxième liste d'adresse (les adresses de la dict) dont l'index vaux 1
            var newLi = jQuery('<li id="contact_urgent_'+ nombreAleatoire +'_' + nombreCuDict + '_' + 1 + '"></li>').html(newWidget);
            
            // console.log(autocompletesWraps);
            
            addDeleteLink(newLi);
            newLi.appendTo($('#partie-dict ul[id=contact-urgent-fields-list]'));
            

        }
        
            
        var form = $('form[name=mairievoreppe_demandetravauxbundle_dtdict]');
        var inputs = form.find('#partie-dt ul[id=contact-urgent-fields-list] li input');
        var select = form.find('#partie-dt ul[id=contact-urgent-fields-list] li select');
        
        //On afiche l'image de chargement avant le setTimeout    

        setTimeout(function(){
            inputs.each(function () {
                if($(this).val() !== '')
                {
                   var valeur = $(this).val();
                   var idSource = $(this).attr('id');
                   var idCible =  idSource.replace(/_dt_/, "_");
                   $('#' + idCible).val(valeur);                   
                }
            });
        ;}, 1000);
    
     //On afiche l'image de chargement avant le setTimeout                  
        setTimeout(function(){
            
            //Je parcours mes select afin d'attribuer la bonne valeur à la liste du genre d'une personne
           select.each(function(){
               
                var valueOptionSelected = $(this).find(':selected').val();
                var idSource = $(this).attr('id');
                var idCible =  idSource.replace(/_dt_/, "_");
                $('#' + idCible).val(valueOptionSelected);   
               
           });            
        }, 1000);
        
        var valueOptionSelected = select.find(':selected').val();
                var idSource = select.attr('id');
                var idCible =  idSource.replace(/_dt_/, "_");
                $('#' + idCible).val(valueOptionSelected); 
        return false;        
}

/**
 * Fonction qui va permettre de remplir les champs de la DICT lorsque l'on a ceux sur la DT quand on veut lié une DT à la DICT
 * 
 */
function remplirDictLieeDtInformationBase()
{
        var form = $('form[name=mairievoreppe_demandetravauxbundle_demandeintentionct]');
        var informationBase = form.find('.information-base');
        var dataDt = $('#recup-dt').attr('data-dt');
        var arr = $.parseJSON(dataDt);
        var dateDebutTravaux = dateStringToInputFormDate(arr.date_debut_travaux);
        console.log(dateDebutTravaux);

        // console.log(arr);

        informationBase.find("input#mairievoreppe_demandetravauxbundle_demandeintentionct_dateDebutTravaux").val(dateDebutTravaux);
        informationBase.find("input#mairievoreppe_demandetravauxbundle_demandeintentionct_duree").val(arr.duree);

        setElementInSelectListeByString($("select#mairievoreppe_demandetravauxbundle_demandeintentionct_canalReception"), arr.canal_reception.libelle);

        informationBase.find("textarea#mairievoreppe_demandetravauxbundle_demandeintentionct_descriptionTravaux").val(arr.description_travaux);
        informationBase.find("textarea#mairievoreppe_demandetravauxbundle_demandeintentionct_noteComplementaire").val(arr.note_complementaire);

        
        // //Je ne parcours pas les selects volontairement: seul le premier sera pris en compte. EN effet, le maire d'oeuvre et d'ouvrage étant différent
        // // c'est à l'utilisateur de les définirs dans chacun des cas
        // var valueOptionSelected = select.find(':selected').val();
        // var idSource = select.attr('id');
        // var idCible =  idSource.replace(/_dt_/, "_");
        // $('#' + idCible).val(valueOptionSelected);   
        
        
}



function remplirDictLieDtAdresse()
{         
    //On récupère l'ensemble du formulaire cible      
    var form = $('form[name=mairievoreppe_demandetravauxbundle_demandeintentionct]');

    //ON récupèère les donnée sérialisé de la DT
    var dataDt = $('#recup-dt').attr('data-dt');

    //On passe en JSON comme dataDt (les données sources)
    var arr = $.parseJSON(dataDt);

    // La première adresse obligatoire, cependant son contenu sera remplacer. Il en va de même pour celles qui sont déjà présente. On ne peut pas les 
    //supprimer simplement du DOM. Il faudrais les remove en temps qu'entité. Autrement dit, on n'efface pas les existante. Leur suppression se fera au clique sur supprimer.
    $('ul[id=adresse-fields-list] li').not(':first').remove();
    
    
    //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
    var nombreAdresseDt = arr.adresses.length;
    
    /**
     * On supprime les instance d'autocomplete étant dans l'intance 0, c'est à dire dans la partie DICT (il n'y a pas de DT)
     */
    for(i = autocompletesWraps.length - 1; i >= 0; i--) {
            autocompletesWraps[i] = autocompletesWraps[i].replace(/adresse(_(.*)_[\d]_0)/,"");
            if (autocompletesWraps[i] === "") {
                autocompletesWraps.splice(i,1);
            }        
        
    }
    
    // console.log("Après suppression : autocompletesWraps => " + autocompletesWraps);
     /******
      * 
      *     Création des prototypes d'adresse
      * 
      */
     //On recréé juste ce qu'il faut d'adresse avec le prototype de DICT, sans jamais remplacer la première et on ne reprend pas 
     //celle de la DT (1+1 = 2)
    for(i=1; i < nombreAdresseDt;i++)
    {
       //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
        var nombreAdresseDict =  $('ul[id=adresse-fields-list]').find('li').length;
        
        // parcourt le template prototype
        var newWidget = $('ul[id=adresse-fields-list]').attr('data-prototype');
        
        //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
        newWidget = newWidget.replace(/<button type="submit"(.*)<\/button><\/div>/ , "");
        
        // console.log(newWidget);
        // remplace les "__name__" utilisés dans l'id et le nom du prototype
        // par un nombre unique pour chaque periode d'exercice
        // le nom de l'attribut final ressemblera à name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, nombreAdresseDict);
        nombreAdresseDict++;
        
        
        
        //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
        //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
        var nombreAleatoire = genererNombreAleatoire();
    
        // créer une nouvelle liste d'éléments et l'ajoute à notre liste qui est la deuxième liste d'adresse (les adresses de la dict) dont l'index vaux 1
        var newLi = jQuery('<li id="adresse_'+ nombreAleatoire +'_' + nombreAdresseDict + '_' + 0 + '"></li>').html(newWidget);
        autocompletesWraps.push("adresse_" + nombreAleatoire +"_" + nombreAdresseDict + "_" + 0);
        
        // console.log(autocompletesWraps);
        
        addDeleteLink(newLi);
        newLi.appendTo($('ul[id=adresse-fields-list]'));
        

    }
    
    
    initializeMutliAdresse();
        
    //Permet de créer l'instance d'autocomplete de google place du champ ajouté via le prototype
    // console.log("Nouvelle initialisation : autocompletesWraps => " + autocompletesWraps);
    var form = $('form[name=mairievoreppe_demandetravauxbundle_dtdict]');
    var inputs = form.find('#partie-dt ul[id=adresse-fields-list] li input');
    
    //On afiche l'image de chargement avant le setTimeout
    $("#corps").animate({height: 'toggle'},2000);
    $('.image-loading-dt-dict img').show();
   
    // console.log(arr.adresses) ; 

    setTimeout(function(){
        $.each(arr.adresses, function(i){
                 console.log($(this)[0].ville); 
                 console.log("index " + i);
                    //eq récupère l'éméent en jQuery. On a un objet pour chaque instance d'adresse. Les données sont
                    //dans le premier tableau soit [0]
                 if($(this)[0].numero_rue !== undefined && $(this)[0].numero_rue != "")
                    $('input[street_number="street_number"]').eq(i).val($(this)[0].numero_rue);

                 if($(this)[0].ville !== undefined && $(this)[0].ville != "")
                    $('input[locality="locality"]').eq(i).val($(this)[0].ville);

                 if($(this)[0].cp !== undefined && $(this)[0].cp != "")
                    $('input[postal_code="postal_code"]').eq(i).val($(this)[0].cp);

                 if($(this)[0].numero_rue !== undefined && $(this)[0].numero_rue != "")
                    $('input[street_number="street_number"]').eq(i).val($(this)[0].numero_rue);

                 if($(this)[0].adresse !== undefined && $(this)[0].adresse!= "")
                    $('input[route="route"]').eq(i).val($(this)[0].adresse);

                 if($(this)[0].lieu_dit !== undefined && $(this)[0].lieu_dit != "")
                    $('input[lieuDit="lieuDit"]').eq(i).val($(this)[0].lieu_dit);
                 
        });

        // //Puis on l'enève une fois que tout les traitements sont terminés
          $('.image-loading-dt-dict img').hide();
          $("#corps").animate({height: 'toggle'},500);
    ;}, 1000);
    
    
    return false;        
    
}

/**
 * Fonction qui va me permettre de remplir mes CU de mes DtDict lié 
 * (il s'agit lorsque l'on ajoute une DICT après une DT)
 */

function remplirDtDictLieContactUrgent()
{
      //On récupère l'ensemble du formulaire cible      
        var form = $('form[name=mairievoreppe_demandetravauxbundle_demandeintentionct]');

        //ON récupèère les donnée sérialisé de la DT
        var dataDt = $('#recup-dt').attr('data-dt');

        //On passe en JSON comme dataDt (les données sources)
        var arr = $.parseJSON(dataDt);
        console.log(arr);
    
        // On ne peut pas supprimer les contact urgents existant au seind 'une DICT (simplement du DOM) 
        // Il faudrais les remove en temps qu'entité. Autrement dit, on n'efface pas les existante. Leur suppression se fera au clique sur supprimer.
        $('ul[id=contact-urgent-fields-list] li').remove();
        
        
        //On récupère le nombre d'adresse du côté DICT grâce au selecteur 'eq(1)' qui est le deuxième élément adresse-fields-list (le premier étant dt)
        var nombreCuDt = arr.contacts_urgent.length;
        
        
        console.log("Après suppression : autocompletesWraps => " + autocompletesWraps);

         /******
          * 
          *     Création des prototypes d'adresse
          * 
          */
         //Aucun contact urgent n'est obligatoire, on les recréer donc tous dans ce cas
        for(i=0; i < nombreCuDt;i++)
        {
            //Contient le nombre de contact urgent pour la DICT ajouter en cours de boucle
            var nombreCuDict =  $('ul[id=contact-urgent-fields-list]').find('li').length;
            
            // parcourt le template prototype
            var newWidget = $('ul[id=contact-urgent-fields-list]').attr('data-prototype');
            
            //On retire le boutton qui supprime un enregistrement ( différent de celui qui supprime une instance du prototype créé via la fonction addDeleteLink()) 
            newWidget = newWidget.replace(/<button type="submit"(.*)<\/button><\/div>/ , "");
            
            console.log(newWidget);
            // remplace les "__name__" utilisés dans l'id et le nom du prototype
            // par un nombre unique pour chaque periode d'exercice
            // le nom de l'attribut final ressemblera à name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, nombreCuDict);
            nombreCuDict++;
            
            
            
            //On génère un nombre aléatoire afin d'avoir une instance unique d'autocomplete, sans quoi si on supprimerai un autocomplete 3, le 5 devient  4 dans le compte
            //et si on en recré un 5 eme, il aurait 5 si on ne prend que le nombre à I itération d'adresse
            var nombreAleatoire = genererNombreAleatoire();
        
            // Il n'y a ici que des DICT, on est alors à l'instance 0. L'homogénétité et la logique est conservé.
            var newLi = jQuery('<li id="contact_urgent_'+ nombreAleatoire +'_' + nombreCuDict + '_' + 0 + '"></li>').html(newWidget);
            
            console.log(autocompletesWraps);
            
            addDeleteLink(newLi);
            newLi.appendTo($('ul[id=contact-urgent-fields-list]'));
            

        }
        
        //On va remplir l'ensemble des CU créé auparavant grâce à la mise à plats des données avec les contacts urgent
        setTimeout(function(){
            //Je parcours mes select afin d'attribuer la bonne valeur à la liste du genre d'une personne
           $.each(arr.contacts_urgent, function(i){
                 console.log($(this)[0].ville); 
                 console.log("index " + i);
                    //eq récupère l'éméent en jQuery. On a un objet pour chaque instance d'adresse. Les données sont
                    //dans le premier tableau soit [0]
                 if($(this)[0].nom !== undefined && $(this)[0].nom != "")
                    $('ul[id=contact-urgent-fields-list] li input[id="mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_'+ i +'_nom"]').val($(this)[0].nom);

                 if($(this)[0].prenom !== undefined && $(this)[0].prenom != "")
                    $('ul[id=contact-urgent-fields-list] li input[id="mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_'+ i +'_prenom"]').val($(this)[0].prenom);

                 if($(this)[0].email !== undefined && $(this)[0].email != "")
                    $('ul[id=contact-urgent-fields-list] li input[id="mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_'+ i +'_email"]').val($(this)[0].email);

                 if($(this)[0].tel_fixe !== undefined && $(this)[0].tel_fixe != "")
                    $('ul[id=contact-urgent-fields-list] li input[id="mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_'+ i +'_telFixe"]').val($(this)[0].tel_fixe);

                 if($(this)[0].tel_mobile !== undefined && $(this)[0].tel_mobile!= "")
                    $('ul[id=contact-urgent-fields-list] li input[id="mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_'+ i +'_telMobile"]').val($(this)[0].tel_mobile);


                setElementInSelectListeByString($("select#mairievoreppe_demandetravauxbundle_demandeintentionct_contactsUrgent_" + i + "_civilite"), $(this)[0].civilite.abreviation);
            //On affiche l'animation du corps après le chargement au sein du setTimout afin de laisser un delay
           // $("#corps").animate({height: 'toggle'},2000);
                     
          });
        }, 1000);

        
        return false;        
}

function dateStringToInputFormDate(date)
{

        var objectDate = new Date(date);

        //On récupère chaque élément
        var month = objectDate.getMonth() + 1;
        var day = objectDate.getDate();
        var year = objectDate.getFullYear();

        var dateFinal = year + "-" + month + "-" + day;

        return dateFinal;
}


function setElementInSelectListeByString(list, textvalue)
{
        list.find("option").filter(function() {
             return this.text == textvalue; 
          }).attr('selected', true);
}

function afficherCalendrier(idInputDate)
{
    $('#' + idInputDate).datepicker({
        dateFormat: 'dd/mm/yy',
        firstDay: 1
    });
}
/**
 * Fonction qui permet de générer un nombre aléatoire
 */
function genererNombreAleatoire()
{
    return Math.floor(Math.random()*110000000) + "" + new Date().getUTCMilliseconds();
}