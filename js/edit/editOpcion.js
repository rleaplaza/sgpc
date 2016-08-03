(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idopcion=$(".idopcion").val();
		    opcion=$(".opcion").val();
			desc=$(".desc").val();
	//validacion de campo
		    if (opcion=="") {
            $(".opcion").focus();
			alert("Complete el campo nombre de opción");
            return false;
		}else if (desc=="") {
            $(".desc").focus();
			alert("Complete el campo nombre de descripcion");
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idopcion='+idopcion+ '&opcion=' + opcion +"&desc="+desc;
            $.ajax({
                type: "POST",
                url: "../registros/updateOpcion.php",
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