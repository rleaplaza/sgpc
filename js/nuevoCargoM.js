(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var  nombre=$(".nombre").val();
			 desc=$(".desc").val();
			 unidad=$(".unidad").val();
			 precio=$(".precio").val();
	//validacion de campo
	        validacion_nombre=/^[a-zA-Z]/;
			validacion_precio=/^[0-9]+(\.[0-9]+)?$/; //validar numero decimal
		
			if(nombre=="" || !validacion_nombre.test(nombre)){
				$(".nombre").focus();
				alert("Campo nombre de cargo incorrecto");
				return false;
			}else if(unidad==""){
				$(".unidad").focus();
				alert("Campo unidad es requerido");
				return false
				} else if(precio=="" || !validacion_precio.test(precio)){
				$(".precio").focus();
				alert("Campo precio unitario incorrecto");
				return false;
			} else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'nombre='+ nombre + '&desc=' + desc + '&unidad=' + unidad + '&precio=' + precio;
            $.ajax({
                type: "POST",
                url: "registros/addCmanoObra.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Registro completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					window.location="registros/log.php";
						
                },
                error: function() {
                    $('.ajaxgif').hide();
           $('.msg').text('Hubo un error en el registro!').addClass('msg_error').animate({ 'right' : '130px' }, 300);                 
                }
            });
            return false;
        }
 
    });
})();