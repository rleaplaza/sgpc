// Programa para la edición de profesiones usando validaciones javascript
(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idprofesion=$(".idprofesion").val();
		    profesion=$(".profesion").val();
			desc=$(".desc").val();
	//validacion de campo
		     if(desc==""){
            $(".desc").focus(); 
			alert("Complete la descripción de la profesion");   
            return false;
		}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'idprofesion='+idprofesion+ '&profesion=' + profesion + '&desc=' + desc;
            $.ajax({
                type: "POST",
                url: "../registros/updateProfesion.php",
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