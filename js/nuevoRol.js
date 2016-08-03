(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idrol = $(".idrol").val();
		    rol=$(".rol").val();
			desc=$(".desc").val();
	//validacion de campo
	     validacion_idrol=/^[a-zA-Z]/;
	     validacion_rol=/^[a-zA-Z]/;
	     validacion_desc=/^[a-zA-Z]/;
			if(idrol=="" || !validacion_idrol.test(idrol)){
				$(".idrol").focus();
				alert("Campo ID de rol incorrecto");
				return false;
			} else if (rol=="" || !validacion_rol.test(rol)) {
                      $(".rol").focus();
			          alert("Campo rol incorrecto");
            return false;
        }else if(desc=="" || !validacion_desc.test(desc)){
            $(".desc").focus(); 
			alert("Campo descripción incorrecto"); 
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idrol='+ idrol + '&rol=' + rol + '&desc=' + desc;
            $.ajax({
                type: "POST",
                url: "registros/addRol.php",
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
