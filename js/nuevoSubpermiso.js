(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idopcion = $(".idopcion").val();
		    subpermiso=$(".subpermiso").val();
			desc=$(".desc").val();
			direccion=$(".direccion").val();
	//validacion de campo
	         validacion_subpermiso=/^[a-zA-Z]/;
			if(subpermiso=="" || !validacion_subpermiso.test(subpermiso)){
				$(".subpermiso").focus();
				alert("Campo nombre de subpermiso incorrecto");
				return false;
			} else if (direccion=="" || !direccion.match(/\.(php)$/)) {
                      $(".direccion").focus();
			          alert("La extensión del archivo debe ser .php");
            return false;
            }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
            var datos = 'idopcion='+ idopcion + '&subpermiso=' + subpermiso + '&desc=' + desc+"&direccion="+direccion;
            $.ajax({
                type: "POST",
                url: "registros/addSubpermiso.php",
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