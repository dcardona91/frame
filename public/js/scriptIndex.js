$(document).ready(function() {
	// var options=['Taller 1','Taller 2','Taller 3','Taller 4','Taller 5','Taller 6','Taller 7','Taller 8','Taller 9','Taller 10'];
	// var select = $('.selectpicker');
 //  	for(var i = 0; i < options.length; i++) {
	//     var opt = options[i];
	//     var el = document.createElement("option");
	//     el.textContent = opt;
	//     el.value = opt;
	//     select.append(el)
	//}
	$(".openModal").click(function(e){
		e.preventDefault();
	});
});

function modalSede(sede, id){	
	$("#asisteSede").val(sede);
	$("#asisteSedeId").val(id);
	$('.hide').trigger('click');
	$('.modal-header').removeClass('header-1');
	$('.modal-header').addClass('header-1');
	$('.modal-title').html('Sede '+sede);
	$('.modal-text').html('Asistencia para la sede '+ sede +' del taller:');
}

function modal(id){
	// var colores = ['header-1','header-2','header-3','header-4','header-5'];
	// var color =  colores[Math.floor(Math.random() * colores.length)];
	$('.hide').trigger('click');
	// $.each(colores,function(i,clase){
	// 	$('.modal-header').removeClass(clase);
	// });	
	$('.modal-header').removeClass('header-1');
	$('.modal-header').addClass('header-1');
	$('.modal-title').html('Sede '+id);
	$("#asisteGrupo").val(id);
	$('.modal-text').html('Asistencia para la sede '+ id +' del taller:');
	$('#myModal').attr('grupo', id);
}



