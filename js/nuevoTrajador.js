(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var  cargomanoobra=$(".cargomanoobra").val();
		     ci=$(".ci").val();
			 ciencargado=$(".ciencargado").val();
		     nombre=$(".nombre").val();
			 app=$(".app").val();
			 apm=$(".apm").val();
			 experiencia=$(".experiencia").val();
			 tel=$(".tel").val();
			 dir=$(".dir").val();
			 fecn=$(".fecn").val();
	//validacion de campo
	        validacion_nombre=/^[a-zA-Z]/;
			validacion_app=/^[a-zA-Z]/;
			validacion_apm=/^[a-zA-Z]/;
		    validacion_fecn=/^\d{4}\/\d{2}\/\d{2}/
			if(ci==""){
			  $(".ci").focus();
			  alert("Campo cedula requerido");
			  return false;	
			}else if(nombre=="" || !validacion_nombre.test(nombre)){
				$(".nombre").focus();
				alert("Campo nombre incorrecto");
				return false;
			}else if(app=="" || !validacion_app.test(app)){
				$(".app").focus();
				alert("Campo apellido incorrecto");
			}else if(experiencia==""){
				$(".experiencia").focus();
				alert("Campo experiencia requerido");
				return false;
			}else if(tel==""){
				$(".tel").focus();
				alert("Campo telefono requerido");
				return false; 
			}else if(dir==""){
				$(".experiencia").focus();
				alert("Campo direccion requerido");
				return false;
			}else if(!(fecn>'1940-01-01' && fecn<='1995-12-31') || fecn==""){
				$(".fecn").focus();
				alert("Fecha de nacimiento invalida");
				return false;
			} else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'cargomanoobra='+ cargomanoobra + '&ci=' + ci + '&ciencargado=' + ciencargado + '&nombre=' + nombre + "&app="+app+"&apm="+apm +"&experiencia="+experiencia+"&tel="+tel+"&dir="+dir+"&fecn="+fecn;
            $.ajax({
                type: "POST",
                url: "registros/addTrabajador.php",
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