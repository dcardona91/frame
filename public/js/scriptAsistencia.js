var conteo = 0;
var estudiantes = [];
var _evento ="";
var posicion = 0;

$(document).ready(function() {
	_evento= $("#numEvento").val();
	$('.footable').footable();	
	 $(".footable1").footable();
	$('table').trigger('footable_clear_filter');$('.filter-api').click(function (e) {    e.preventDefault();var footableFilter = $('table').data('footable-filter');alert('about to filter table by "tech"');footableFilter.filter('tech');if (confirm('clear filter now?')) {footableFilter.clearFilter();}});	
	$('.sort-column').click(function (e) {e.preventDefault();var footableSort = $('table').data('footable-sort');var index = $(this).data('index');var ascending = $(this).data('ascending');footableSort.doSort(index, ascending);});
	$('.btnlist').each(function(index, el) {
	$(this).addClass('glyphicon glyphicon-ok');
	});

	$('.btnlist').click(function(){
		var tr = $(this).parent().parent();
		var nombre = tr.find(".tNombre").html();
		var grado = tr.find(".tGrado").html();
		var documento = tr.find(".tDoc").html();		
		var edad = tr.find(".tEdad").html();
		//var datos = $(this).data("i");
		var idDato = $(this).data("ide");

		var tratt = tr.attr('selected');
		if(tratt==null)
		{
			$(this).removeClass('glyphicon glyphicon-ok');
			$(this).addClass('glyphicon glyphicon-remove');
			tr.addClass('selected');
			tr.attr('selected', '1');
			ftAddRow(".footable1",[nombre,grado,documento,edad],idDato);
			conteo++;
			$('.conteo').html(conteo);
			$('.conteo').hide();
			$('.conteo').show('Bounce');
		}
		else{
			$(this).removeClass('glyphicon glyphicon-remove');
			$(this).addClass('glyphicon glyphicon-ok');
			tr.removeClass('selected');
			tr.attr('selected', null);
			ftRemoveRow(".footable1",idDato);
			conteo--;
			$('.conteo').html(conteo);
			$('.conteo').hide();
			$('.conteo').show('Bounce');
		}
	});
	

});


function ftAddRow(ti, fila,id){	
	var tds = "";
	$.each(fila, function (j, col){
            	tds = tds+"<td>"+col+"</td>";
                });
	var footable = $(ti).data('footable');
    footable.appendRow("<tr class='confirmaAsiste rConfirma-"+id+"' data-in='"+id+"' >"+tds+"</td>");
}

function ftRemoveRow(ti, id){	
	var footable = $(ti).data('footable');
    var row = $(ti+' .rConfirma-'+id);
    footable.removeRow(row);
}

function asistencias(){	
	conteo > 0 ? $('.hide').trigger('click'): false;
	$("#conteoConfirmacion").html(conteo);
}


function enviarAsistencia(){
	//console.log(html2json(".footable1"));
	mt("s");
	var jsonObject = [];
	$("#table2 .confirmaAsiste").each(function(i,v){
		var idEst = $(v).data("in");
		 jsonObject.push({idEstudiante: idEst});
	});

	var token = $("#tokenAsitencia").val();
    var pathSitio = $("#pathSitio").val();
    var jsonConfirm = JSON.stringify(jsonObject);
	$('<form>', {
    "id": "getInvoiceImage",
    "html": "<input type='hidden' id='cratedFormInput_1' name='token' value='" + token + "'' /><input type='hidden' id='cratedFormInput_2' name='jsonConfirm' value='" + jsonConfirm + "' /><input type='hidden' id='cratedFormInput_3' name='numEvento' value='" + _evento + "' />",
    "action": pathSitio + 'asistencia/confirmar',
    "method": "post"
}).appendTo(document.body).submit();
	//console.log(JSON.stringify(jsonConfirm));
	//confirmarAsistencia(JSON.stringify(jsonConfirm));
}

function html2json(laTabla) {
   var json = '{';
   var otArr = [];
   var tbl2 = $(laTabla+' tr').each(function(i) {        
      x = $(this).children();
      var itArr = [];
      x.each(function() {
         itArr.push('"' + $(this).text() + '"');
      });
      otArr.push('"' + i + '": [' + itArr.join(',') + ']');
   })
   json += otArr.join(",") + '}'

   return json;
}


$(".cerrarTelon").click(function(){
   $("#telon").addClass("hide"); 
   $("#successConfirma, #errorConfirma, #sending").removeClass("animated bounce");
  $("#successConfirma, #errorConfirma, #sending").addClass("hide");
});
function cerrarTelon(){
	$("#telon").addClass("hide"); 
	   $("#successConfirma, #errorConfirma, #sending").removeClass("animated bounce");
	  $("#successConfirma, #errorConfirma, #sending").addClass("hide");
}

function cs(){
    $("#successConfirma, #errorConfirma, #sending").removeClass("animated bounce");
    $("#successConfirma, #errorConfirma, #sending").addClass("hide");
}


function mt(which){
      $("#telon").removeClass("hide");
      switch (which) {
          case "o":  
          cs();
          $("#successConfirma").removeClass("hide").addClass("animated bounce");
           break;
          case "e":  
          cs();
          $("#errorConfirma").removeClass("hide").addClass("animated bounce");
           break;
          case "s": 
          cs(); 
          $("#sending").removeClass("hide");
           break;
                  }  
};