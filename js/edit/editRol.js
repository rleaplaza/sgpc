(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idrol=$(".idrol").val();
		    rol=$(".rol").val();
			desc=$(".desc").val();
	//validacion de campo
		    if (rol=="") {
            $(".rol").focus();
			alert("Complete el campo nombre de rol");
            return false;
        }else if(desc==""){
            $(".desc").focus(); 
			alert("Complete la descripcion del rol");   
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idrol='+idrol+ '&rol=' + rol + '&desc=' + desc;
            $.ajax({
                type: "POST",
                url: "../registros/updateRol.php",
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