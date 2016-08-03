(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var proyecto = $(".proyecto").val();
		    conv=$(".conv").val();
			depa=$(".depa").val();
			fecInicio=$(".fecInicio").val();
			fecFin=$(".fecFin").val();
			monto=$(".monto").val();
			responsable=$(".responsable").val();
	        fechaActual=$(".fechaActual").val();
	//validacion de campo
	        validacion_modulo=/^[a-zA-Z]/;
			validacion_conv=/^[a-zA-Z]/;
			validacion_monto=/^[0-9]+(\.[0-9]+)?$/;
			if(proyecto==""){
			$(".proyecto").focus();
			alert("El campo proyecto es requerido");
			return false;
	       }else if(conv=="" || !validacion_conv.test(conv)){
				$(".conv").focus();
				alert("Campo convocatoria incorrecto");
				return false;
			} else if (fecInicio == "") {
            $(".fecInicio").focus();
			alert("Fecha incorrecta");
            return false;
			}else if(fecFin=="" || fecFin<=fecInicio){
			   $(".fecFin").focus();
			   alert("Fecha de finalizacion incorrecta");
			   return false;
            }else if(fecInicio<fechaActual){
				$(".fecInicio").focus();
				alert("La fecha de inicio es pasada");
				return false;
			}else if(fecFin<fechaActual){
			    $("fecFin").focus();
				alert("La fecha de fin es pasada");
				return false;
			}else if(monto=="" || !validacion_monto.test(monto)){
			   $(".monto").focus();
			   alert("Campo monto requerido");
			   return false;
			}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
   var datos = 'proyecto='+ proyecto +'&depa='+depa+'&conv=' + conv +"&fecInicio="+fecInicio+"&fecFin="+fecFin+"&monto="+monto+"&responsable="+responsable;
            $.ajax({
                type: "POST",
                url: "registros/addProyecto.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Registro completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 1000);  
					window.location="registros/log.php";
						
                },
                error: function() {
                    $('.ajaxgif').hide();
           $('.msg').text('Hubo un error en el registro!').addClass('msg_error').animate({ 'right' : '130px' }, 1000);                 
                }
            });
            return false;
        }
 
    });
})();