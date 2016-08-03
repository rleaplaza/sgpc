(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idmaquinaria=$(".idmaquinaria").val();
			precio=$(".precio").val();
			validacion_precio=/^[0-9]+(\.[0-9]+)?$/;
	//validacion de campo
		     if(precio=="" || !(validacion_precio.test(precio))){
            $(".desc").focus(); 
			alert("Campo precio es incorrecto");   
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idmaquinaria='+idmaterial+ '&precio=' + precio;
            $.ajax({
                type: "POST",
                url: "../registros/updateMaquinaria.php",
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