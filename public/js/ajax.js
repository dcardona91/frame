$("#frmRecuperar").submit(function(e){
  var token = $("#token").val();
  var action = $("#frmRecuperar").attr("action");
  var user = $("#usuario").val();

  var parametros = {
      "user": user,
      "token":token
    };

     $.ajax(
          {      
              url : action,
              type: "POST",
              data : parametros,
              beforeSend: function(){
                $('body,html').animate({scrollTop: 0}, 800);
                mt("s");
              },
              success:function(data) 
              {
                console.log(data);
                  var respuesta = data.split("~");
                 if (respuesta[0] == "ok") 
                  {                                                                          
                    mt("o",respuesta[1]);
                    /**/
                  }
                 else
                  {    
                    mt("e",respuesta[2]);
                  };
              }
              
          }); 
  e.preventDefault();
});

/*
instEdu
sedeEdu
*/
 $("#instEdu").change(function () {
    //console.log("cambio 1");  
           $("#instEdu option:selected").each(function () {
            var idIe = $(this).val();
            if (idIe == '**') {

            $("#sedeEdu").html("<option value='**'>Seleccione una institución</option>");
            $("#sedeEdu").selectpicker('refresh');
            }else
            {
            var action = $("#pathsitio").val()
            var token = $("#token").val()
            var parametros = {"idIe": idIe,
                              "token": token
                            };
            $.ajax(
                  {      
                      url : action+"estudiante/sedes",
                      type: "POST",
                      data : parametros,
                      success:function(data) 
                      {      
                     //console.log(data);                   
                         if (data=="error") 
                          {
                            console.log(data);                           
                          }
                         else
                          {  
                            construirSelect(data);
                             $("#slctCiudad").html(data);
                           
                          };
                      }
                      
                  }); 
            };   
                 
        });
});

function construirSelect(json)
{
  var rpta = JSON.parse(json);
  var option = "<option value='**'>Selecciona una sede</option>";
  //console.log(rpta);
  $.each(rpta.sedes, function(key, value){
    option = option+"<option value='"+value.id+"'>"+value.nombre+"</option>";
  });
  $("#sedeEdu").html(option);
  $("#sedeEdu").selectpicker('refresh');
  $("#token").val(rpta.token);
}


function confirmarCorreo(jasonConfirma){
    var token = $("#tokenAsitencia").val();
    var pathSitio = $("#pathSitio").val();
    var deAction =  pathSitio+"asistencia/confirmar";
    //console.log(deAction);
    var parametros = {
      "json": jasonConfirma,
      "token":token
    };
     $.ajax(
          {      
              url : deAction,
              type: "POST",
              data : parametros,
              beforeSend: function(){
                $('body,html').animate({scrollTop: 0}, 800);
                mt("s");
              },
              success:function(data) 
              {       
                $("#cerrarAsistenciaModal").click();
                //console.log(data);
                 if ($.trim(data) == 1) 
                  {                                                                          
                    mt("o");
                  }
                 else
                  {    
                    mt("e");
                  };
              }
              
          }); 
};
