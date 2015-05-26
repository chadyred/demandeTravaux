/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    //alert("document prêt");
    $('select').on('click', function() {
    $.fn.insertAtCaret(this.value); // or $(this).val()
    });
    
});
    $.fn.insertAtCaret = function (myValue) {
      //  alert("dans caret");
    myValue = myValue.trim();
    //alert("myValue" + myValue);
    CKEDITOR.instances["mairievoreppe_demandetravauxbundle_arretemodel_contenu"].insertText(myValue);
};
