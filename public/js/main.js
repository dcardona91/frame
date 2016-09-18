$(document).ready(function(){

  $("#frmNuevotest").submit(function(e)
{
    var action = $(this).attr("action")+"estudiantes/ajaxSet/";
    var serial = $("#txtBuscar").val();
    var datos = $(this).serialize();
    $.ajax(
    {
        url : action,
        type: "POST",
        data : datos,
        success:function(data) 
        {
            var allRes = $.parseJSON(data);
          	makeTable(allRes.results);
            $("#t0k3n").val(allRes.token);
            //console.log($.parseJSON(data));
          	$("#frmNuevotest input[type='text'], #frmNuevotest input[type='password']").val("");
          	//console.log(data);
        }     
    });
    e.preventDefault(); 
});

});


function makeTable(arr)
{
 		//var filas = '';
        $.each(arr, function (i, fila) {
            //filas += '<tr><td>' + fila.id + '</td><td>' + fila.nombre + '</td></tr>';
            $tr = $("<tr></tr>");
                $.each(fila, function (j, col){
                    $td = $("<td></td>");
                    $td.html(col);
                    $td.appendTo($tr);
                });
            $tr.appendTo('#tabla_rpta');
        });
        //console.log(filas);
        //$('#tabla_rpta').html(filas);	
}
