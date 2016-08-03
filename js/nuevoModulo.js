(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var modulo = $(".modulo").val();
		    descmodulo=$(".descmodulo").val();
	//validacion de campo
	        validacion_modulo=/^[a-zA-Z]/;
			validacion_descmodulo=/^[a-zA-Z]/;
			if(modulo=="" || !validacion_modulo.test(modulo)){
				$(".modulo").focus();
				alert("Campo menú incorrecto");
				return false;
			} else if (descmodulo == "" || !validacion_descmodulo.test(descmodulo)) {
            $(".modulo").focus();
			alert("Campo descripción incorrecto");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'modulo='+ modulo + '&descmodulo=' + descmodulo;
            $.ajax({
                type: "POST",
                url: "registros/addModulo.php",
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