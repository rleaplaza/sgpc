(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idsubmenu = $(".idsubmenu").val();
		    opcion=$(".opcion").val();
			desc=$(".desc").val();
			direccion=$(".direccion").val();
	//validacion de campo
	     validacion_opcion=/^[a-zA-Z]/;
			if(opcion=="" || !validacion_opcion.test(opcion)){
				$(".opcion").focus();
				alert("Campo nombre de opcion incorrecto");
				return false;
			} else if (direccion=="" || !direccion.match(/\.(php)$/)) {
                      $(".direccion").focus();
			          alert("La extensión del archivo debe ser .php");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idsubmenu='+ idsubmenu + '&opcion=' + opcion + '&desc=' + desc+"&direccion="+direccion;
            $.ajax({
                type: "POST",
                url: "registros/addOpcion.php",
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