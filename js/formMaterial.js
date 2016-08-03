(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var idproveedor = $(".idproveedor").val();
		    desc=$(".desc").val();
			unidad=$(".unidad").val();
			precio=$(".precio").val();
	//validacion de campo
			validacion_unidad=/^[a-zA-Z]/;
			validacion_precio=/^[0-9]+(\.[0-9]+)?$/;
			if(desc==""){
			$(".desc").focus();
			alert("El campo descripción es requerido");
			return false;
	       }else if(precio=="" || !validacion_precio.test(precio)){
			   $(".precio").focus();
			   alert("Campo precio incorrecto, el formato es 00.00");
			   return false;
			}else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
   var datos = 'idproveedor='+ idproveedor + '&desc=' + desc +"&unidad="+unidad+"&precio="+precio;
            $.ajax({
                type: "POST",
                url: "registros/addMaterial.php",
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