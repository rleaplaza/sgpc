(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var email = $(".email").val();
			password=$(".password").val();
			confpassword=$(".confpassword").val();
			notificacion=$(".rbnotificacion").val();
			//tipo=$(".tipousuario").val();
	//validacion de campos 
			validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
		
			validacion_password=/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{5,10})$/; 
			validacion_confpassword=/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{5,10})$/;
        if (email == "" || !validacion_email.test(email)) {
            $(".email").focus();
			$(".email").val()="";
			alert("Campo email incorrecto");
            return false;
        }else if(password == "" || !validacion_password.test(password)){
              alert(" El password debe ser entre 8 y 10 caracteres, por lo menos un digito y un alfanumérico, y no puede contener caracteres espaciales");
            $(".password").focus();
            return false;
        }else if( password=!confpassword){
				alert("El password y su confirmacion deben ser iguales");
				$(".confpassword").focus();
				return false;
				}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'email='+ email + '&password=' + password + '&confpassword=' + confpassword+'&notificacion='+notificacion;
            $.ajax({
                type: "POST",
                url: "updateCuenta.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Actualización completa!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);
					//window.location="editCuenta.php";
						
                },
                error: function() {
                    $('.ajaxgif').hide();
           $('.msg').text('Hubo un error en la actualizacion!').addClass('msg_error').animate({ 'right' : '130px' }, 300);                 
                }
            });
            return false;
        }
 
    });
})();
