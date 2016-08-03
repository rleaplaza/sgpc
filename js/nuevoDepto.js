(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var depto = $(".depto").val();
		    descdepto=$(".descdepto").val();
	//validacion de campo
	        validacion_modulo=/^[a-zA-Z]/;
			if(depto=="" || !validacion_modulo.test(depto)){
				$(".depto").focus();
				alert("Campo departamento incorrecto");
				return false;
			} else if (descdepto == "") {
            $(".descdepto").focus();
			alert("Campo descripción incorrecto");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'depto='+ depto+ '&descdepto=' + descdepto;
            $.ajax({
                type: "POST",
                url: "registros/addDepto.php",
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