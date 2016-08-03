(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var salario=$(".salario").val();
			userId=$(".userId").val();
	//validacion de campo
			validacion_salario=/^[0-9]+(\.[0-9]+)?$/; //validar numero decimal
		   if (salario == "" || salario<1200) {
            $(".salario").focus();
			alert("Campo haber básico incorrecto");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'salario='+salario +"&userId="+userId;
            $.ajax({
                type: "POST",
                url: "updateEmpleado.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Actualizacion Completa!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					window.location="../userEmpleado.php";
						
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