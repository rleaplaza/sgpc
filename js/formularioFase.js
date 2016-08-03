(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var proyecto = $(".proyecto").val();
		    fase=$(".fase").val();
			longitud=$(".longitud").val();
	//validacion de campo
	        validacion_precio=/[-+]?([0-9]*\.[0-9]+|[0-9]+)/;
			validacion_longitud=/[-+]?([0-9]*\.[0-9]+|[0-9]+)/;
			if(fase==""){
				$(".fase").focus();
				alert("Campo fase requerido");
				return false;
			} else if (longitud== "" || !validacion_longitud) {
            $(".longitud").focus();
			alert("Campo longitud incorrecto");
            return false;
			}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
			var datos = 'proyecto='+ proyecto + '&fase=' + fase +"&longitud="+longitud;
 
            $.ajax({
                type: "POST",
                url: "registros/addFase.php",
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