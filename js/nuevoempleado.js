(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var  f=new Date();
		     fecha=f.getYear()+"-"+f.getMonth()+"-"+f.getDay();
			 nombre=$(".nombre").val();
			 app=$(".app").val();
			 apm=$(".apm").val();
			 ci=$(".ci").val();
			 tel=$(".tel").val();
			 dir=$(".dir").val();
			 fecn=$(".fecn").val();
			 estadocivil=$(".estadocivil").val();
		    fecIngreso = $(".fecIngreso").val();
		    cargo=$(".cargo").val();
			depto=$(".depto").val();
			profesion=$(".profesion").val();
			salario=$(".salario").val();
	//validacion de campo
	        validacion_nombre=/^[a-zA-Z]/;
			validacion_app=/^[a-zA-Z]/;
			validacion_apm=/^[a-zA-Z]/;
		    validacion_fecn=/^\d{4}\/\d{2}\/\d{2}/
		    validacion_fecIngreso=/^\d{4}\/\d{2}\/\d{2}/;
			validacion_salario=/^[0-9]+(\.[0-9]+)?$/; //validar numero decimal
			validacion_hraIngreso=/^(0[1-9]|1\d|2[0-3]):([0-5]\d):([0-5]\d)/; //validar formato de hora HH:MM:SS
			if(nombre=="" || !validacion_nombre.test(nombre)){
				$(".nombre").focus();
				alert("Campo nombre incorrecto");
				return false;
			}else if(app=="" || !validacion_app.test(app)){
				$(".app").focus();
				alert("Campo apellido incorrecto");
			}else if(!(fecn>'1940-01-01' && fecn<='1995-12-31') || fecn==""){
				$(".fecn").focus();
				alert("Fecha de nacimiento invalida");
				return false;
			}else if(fecIngreso==""){
				$(".fecIngreso").focus();
				alert("Fecha de ingreso no valida");
				return false;
			} else if (salario == "" || !validacion_salario.test(salario) || salario<1200) {
            $(".salario").focus();
			alert("Campo haber básico incorrecto");
            return false;
        } else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'nombre='+ nombre + '&app=' + app + '&apm=' + apm + '&ci=' + ci + "&tel="+tel+"&dir="+dir +"&fecn="+fecn+"&estadocivil="+estadocivil+"&fecIngreso="+fecIngreso+"&profesion="+profesion+"&cargo="+cargo+"&depto="+depto+"&salario="+salario;
            $.ajax({
                type: "POST",
                url: "registros/addempleado.php",
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