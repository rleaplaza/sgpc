(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idsubmenu=$(".idsubmenu").val();
		    submenu=$(".submenu").val();
	//validacion de campo
		    if (submenu=="") {
            $(".submenu").focus();
			alert("Complete el campo nombre de submenú");
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idsubmenu='+idsubmenu+ '&submenu=' + submenu;
            $.ajax({
                type: "POST",
                url: "../registros/updateSubMenu.php",
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