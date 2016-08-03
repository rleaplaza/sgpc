(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idmenu = $(".modulo").val();
		    submenu=$(".submenu").val();
	//validacion de campo
	        validacion_submenu=/^[a-zA-Z]/;
			if(submenu=="" || !validacion_submenu.test(submenu)){
				$(".submenu").focus();
				alert("Campo submenu incorrecto");
				return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idmenu='+ idmenu + '&submenu=' + submenu;
            $.ajax({
                type: "POST",
                url: "registros/addsubMenu.php",
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