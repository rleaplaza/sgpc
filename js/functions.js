(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var username=$(".username").val();
		    email = $(".email").val();
			password=$(".password").val();
			confpassword=$(".confpassword").val(); 
			cedula=$(".cedula").val();
			//tipo=$(".tipousuario").val();
	//validacion de campos
			validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
			validacion_username=/^[a-zA-Z]/;
			validacion_password=/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
			validacion_confpassword=/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
        if (username == "") {
            $(".username").focus();
			alert("El campo username es requerido");
            return false;
        }else if(email=="" || !validacion_email.test(email)){
			$(".email").focus();
			alert("Email incorrecto");
			return false
			}else if(password == "" || !validacion_password.test(password)){
            alert("El password debe ser entre 8 y 10 caracteres, por lo menos un digito y un alfanumérico, y no puede contener espacios");
            $(".password").focus();
            return false;
        }else if( confpassword=="" || password!=confpassword){
				alert("El password y su confirmacion deben ser iguales");
				$(".confpassword").focus();
				return false;
				}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'username='+ username+ '&email='+email+'&password=' + password+ '&confpassword=' + confpassword + '&cedula=' + cedula;
            $.ajax({
                type: "POST",
                url: "registros/adduser.php",
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
