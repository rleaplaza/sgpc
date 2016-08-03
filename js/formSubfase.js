(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idfase = $(".idfase").val();
		    subfase=$(".subfase").val();
			desc=$(".desc").val();
	//validacion de campo
	        validacion_subfase=/^[a-zA-Z]/;
		   if (subfase== "" || !validacion_subfase.test(subfase)) {
            $(".subfase").focus();
			alert("El campo subfase sólo permite texto");
            return false;
			}else if(desc==""){
			   $(".desc").focus();
			   alert("Campo descripción requerido");
			   return false;
			}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
			var datos = 'idfase='+ idfase + '&subfase=' + subfase +"&desc="+desc;
 
            $.ajax({
                type: "POST",
                url: "registros/addSubFase.php",
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