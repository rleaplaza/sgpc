(function(){
	//Este archivo javascript se encarga de capturar los campos del formulario de actividad usando ajax
    $(".boton_envio").click(function() {
 //captura de campos del formulario en base a la clase css definida en el formulario html de actividad
 //cada campo se captura por el valor que contenga
        var idpersonaltecnico = $(".idpersonaltecnico").val();
		    idsubfase=$(".idsubfase").val();
			actividad=$(".actividad").val();
			unidad=$(".unidad").val();
			cantidad=$(".cantidad").val();
			fecInicio=$(".fecInicio").val();
			fecFin=$(".fecFin").val();
	//validacion de campo mediante expresiones regulares para texto y números decimales
	        validacion_actividad=/^[a-zA-Z]/;
			validacion_unidad=/^[a-zA-Z]/;//texto
	        validacion_cantidad=/[-+]?([0-9]*\.[0-9]+|[0-9]+)/;//número decimal
			if(actividad=="" || !validacion_actividad.test(actividad)){
				$(".actividad").focus();//enfoca al campo errado
				alert("El campo actividad sólo permite texto");//mensaje de alerta
				return false;
			} else if (unidad== "" || !validacion_unidad.test(unidad)) {//validación del campo unidad si no cumple lo requerido
            $(".longitud").focus();
			alert("Campo longitud incorrecto");
            return false;
			}else if(cantidad=="" || !validacion_cantidad.test(cantidad)){//validación del campo cantidad
			   $(".cantidad").focus();//enfoca al campo
			   alert("Campo cantidad es numérico");//mensaje de alerta
			   return false;//devuelve false en caso de que el campo no cumpla la validación
			}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');//imagen para cargar el proesamiento
            //la variable datos contatena todos los campos de formulario
			var datos = 'idpersonaltecnico='+ idpersonaltecnico + '&idsubfase=' + idsubfase +"&actividad="+actividad+"&unidad="+unidad+"&cantidad="+cantidad+"&fecInicio="+fecInicio+"&fecFin="+fecFin;
 
            $.ajax({
                type: "POST",//métod post
                url: "registros/addActividad.php",//url destino
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();//oculta la imagen
                    //mensaje de confiramción
                    $('.msg').text('Registro completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					window.location="registros/log.php";//direcciona al archivo de confirmación del registro
						
                },
                error: function() {
                    $('.ajaxgif').hide();
                    //mensaje de error
           $('.msg').text('Hubo un error en el registro!').addClass('msg_error').animate({ 'right' : '130px' }, 300);                 
                }
            });
            return false;
        }
 
    });
})();