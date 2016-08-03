(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idpagina=$(".idpagina").val();
		    subpermiso=$(".subpermiso").val();
			desc=$(".desc").val();
	//validacion de campo
		    if (subpermiso=="") {
            $(".subpermiso").focus();
			alert("Complete el campo subpermiso");
            return false;
		}else if (desc=="") {
            $(".desc").focus();
			alert("Complete el descripcion");
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idpagina='+idpagina+ '&subpermiso=' + subpermiso +"&desc="+desc;
            $.ajax({
                type: "POST",
                url: "../registros/updateSubpermiso.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Registro completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					window.location="../registros/updateMessage.php";
						
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