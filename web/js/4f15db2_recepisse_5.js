$(document).ready(function(){$("#datetimepicker").datetimepicker({inline:true,sideBySide:true});$("#proto-reponse").on("click",function(){var prototypeDeChamps=$(this).find("option:selected").attr("data-prototype");prototypeDeChamps=prototypeDeChamps.replace(/__name__label__/,"");if($("#reponse li").length>0)$("#reponse li").remove();ensembleDeChampConcret=prototypeDeChamps.replace(/__name__/g,0);var newLi=$('<li id="'+$(this).val()+'"></li>').html(ensembleDeChampConcret);newLi.appendTo($("#reponse"))});var prototypeDeChampsRO=$("table#list-emplacement-reseau-ouvrage").attr("data-prototype");var nombreDeChamps=2,i=0;while(i<nombreDeChamps){unChamp=prototypeDeChampsRO.replace(/__name__/g,i);var newTr=$("<tr id=RO_"+i+"></tr>");var containerHtml=$("<div></div>").html(unChamp);var inputReference=containerHtml.find('input[field="reference"]').parent();var inputEchelle=containerHtml.find('input[field="echelle"]').parent();var inputDateEdition=containerHtml.find('input[field="dateEdition"]').parent();var inputSensible=containerHtml.find('input[field="sensible"]').parent();var inputProfondeurReglMini=containerHtml.find('input[field="profondeurReglMini"]').parent();var inputMateriauxReseau=containerHtml.find('input[field="materiauxReseau"]').parent();var tdReference=$("<td></td>").html(inputReference);var tdEchelle=$("<td></td>").html(inputEchelle);var tdDateEdition=$("<td></td>").html(inputDateEdition);var tdSensible=$("<td></td>").html(inputSensible);var tdProfondeurReglMini=$("<td></td>").html(inputProfondeurReglMini);var tdMateriauxReseau=$("<td></td>").html(inputMateriauxReseau);tdReference.appendTo(newTr);tdEchelle.appendTo(newTr);tdDateEdition.appendTo(newTr);tdSensible.appendTo(newTr);tdProfondeurReglMini.appendTo(newTr);tdMateriauxReseau.appendTo(newTr);newTr.appendTo($("table#list-emplacement-reseau-ouvrage tbody"));i++}$("#proto-rendez-vous").on("click",function(){var prototypeDeChamps=$(this).find("option:selected").attr("data-prototype");prototypeDeChamps=prototypeDeChamps.replace(/__name__label__/,"");if($("#rendez-vous p").length>0)$("#rendez-vous p").remove();ensembleDeChampConcret=prototypeDeChamps.replace(/__name__/g,0);var newLi=$('<p id="'+$(this).val()+'"></p>').html(ensembleDeChampConcret);newLi.appendTo($("#rendez-vous"))})});