(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idcargo=$(".idcargo").val();
		    cargo=$(".cargo").val();
			desccargo=$(".desccargo").val();
	//validacion de campo
		     if(desccargo==""){
            $(".desccargo").focus(); 
			alert("Complete la descripcion del cargo");   
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idcargo='+idcargo+ '&cargo=' + cargo + '&desccargo=' + desccargo;
            $.ajax({
                type: "POST",
                url: "../registros/updateCargo.php",
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