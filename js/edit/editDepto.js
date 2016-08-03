(function(){
	//Este programa js se encarga de realizar validaciones a los campos de formulario
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var iddepto=$(".iddepto").val();//captura el id del departamento mediante nombre de la clase
		    depto=$(".depto").val();//captura del departamento
			descdepto=$(".descdepto").val();//captura de la descripción
	//validacion de campo
		     if(descdepto==""){
            $(".descdepto").focus(); //enfoca al campo en caso de que esté vacío
			alert("Complete la descripcion del departamento");   //mensaje de alerta
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');//imagen de carga oculta en el formulario
  var datos = 'iddepto='+iddepto+ '&depto=' + depto + '&descdepto=' + descdepto;//varibable que almacena los datos del formulario
            $.ajax({
                type: "POST",
                url: "../registros/updateDepto.php",//url destino
				data: datos,//datos requeridos que llama a la variable
				//dataType:'html',
                success: function() {//función de registro 
                    $('.ajaxgif').hide();
					//mensaje de confirmación
                    $('.msg').text('Registro completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					//destino de direccionamiento
					window.location="../registros/updateMessage.php";
						
                },
                error: function() {
                    $('.ajaxgif').hide();//imagen de error
					//mensaje de error
           $('.msg').text('Hubo un error en el registro!').addClass('msg_error').animate({ 'right' : '130px' }, 300);                 
                }
            });
            return false;
        }
 
    });
})();