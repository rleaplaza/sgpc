(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var profesion = $(".profesion").val();
		    desc=$(".desc").val();
	//validacion de campo
	        validacion_modulo=/^[a-zA-Z]/;
			if(profesion=="" || !validacion_modulo.test(profesion)){
				$(".profesion").focus();
				alert("Campo profesion incorrecto");
				return false;
			} else if (desc == "") {
            $(".desc").focus();
			alert("Campo descripción incorrecto");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'profesion='+ profesion + '&desc=' + desc;
            $.ajax({
                type: "POST",
                url: "registros/addProfesion.php",
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