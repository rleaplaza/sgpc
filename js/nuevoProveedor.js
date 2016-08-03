(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var userid = $(".userid").val();
		    nombre=$(".nombre").val();
			app=$(".app").val();
			apm=$(".apm").val();
			ci=$(".ci").val();
			empresa=$(".empresa").val();
			dir=$(".dir").val();
			tel=$(".tel").val();
	//validacion de campo
	        validacion_nombre=/^[a-zA-Z]/;
			validacion_app=/^[a-zA-Z]/;
			validacion_apm=/^[a-zA-Z]/;
			if(nombre=="" || !validacion_nombre.test(nombre)){
				$(".nombre").focus();
				alert("Campo nombre incorrecto");
				return false;
			} else if(app=="" || !validacion_app.test(app)){
				$(".app").focus();
				alert("Campo apellido paterno incorrecto");
			    return false;
			}else if(apm=="" || !validacion_apm.test(apm)){
				$(".apm").focus();
				alert("Campo apellido materno incorrecto");
			    return false;
			} else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'userid='+userid+'&nombre='+ nombre + '&app=' + app+"&apm="+apm+"&ci="+ci+"&empresa="+empresa+"&dir="+dir+"&tel="+tel;
            $.ajax({
                type: "POST",
                url: "registros/addProveedor.php",
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