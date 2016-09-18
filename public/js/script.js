$('.mcontra').click(function(event) {
  window.location.href ="recuperar";
});


function errLogIn(){
	var usr = $('#usuario');
	var contra = $('#contra');
		usr.addClass('error');
		contra.addClass('error');
		$('.merror').css('display','block');
		$('.mcontra').css('display','block');
}

$(".cerrarTelon").click(function(){
   $("#telon").addClass("hide"); 
   $("#successConfirma, #errorConfirma, #sending").removeClass("animated bounce");
  $("#successConfirma, #errorConfirma, #sending").addClass("hide");
});

function cs(){
    $("#successConfirma, #errorConfirma, #sending").removeClass("animated bounce");
    $("#successConfirma, #errorConfirma, #sending ,#ajmensaje").addClass("hide");
}


function mt(which, dato){
      $("#telon").removeClass("hide");
      switch (which) {
          case "o":  
          cs();
          $("#successConfirma").removeClass("hide").addClass("animated bounce");
          $("#ajmensaje").removeClass("hide").addClass("animated zoomIn").html("<p class='msjConfirma'>Le hemos enviado a su correo la contraseña nueva</p>");
           $(".hideAfter").addClass("hide");
           $(".msjAfter").html("Su nueva contraseña fue enviada a <strong>"+dato+"@xxxxxxxxx</strong><br/>");
           break;
          case "e":  
          cs();
          $("#errorConfirma").removeClass("hide").addClass("animated bounce");
          $("#ajmensaje").removeClass("hide").addClass("animated zoomIn").html("<p class='msjConfirma'>La identificación es incorrecta</p>");
          $("#token").val(dato);
           break;
          case "s": 
          cs(); 
          $("#sending").removeClass("hide");
          $("#ajmensaje").removeClass("hide").addClass("animated zoomIn").html("<p class='msjConfirma'>Enviando correo</p>");
           break;
                  }  
};