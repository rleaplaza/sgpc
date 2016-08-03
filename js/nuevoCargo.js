(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var cargo = $(".cargo").val();
		    desccargo=$(".desccargo").val();
	//validacion de campo
	        validacion_modulo=/^[a-zA-Z]/;
			if(cargo=="" || !validacion_modulo.test(cargo)){
				$(".cargo").focus();
				alert("Campo cargo incorrecto");
				return false;
			} else if (desccargo == "") {
            $(".desccargo").focus();
			alert("Campo descripción incorrecto");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'cargo='+ cargo + '&desccargo=' + desccargo;
            $.ajax({
                type: "POST",
                url: "registros/addCargo.php",
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