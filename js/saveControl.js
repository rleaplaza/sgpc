(function(){
    $(".boton_envio").click(function() {
 //captura de campos del formulario
        var  f=new Date();
		     fecha=f.getYear()+"-"+f.getMonth()+"-"+f.getDay();
		    motivo = $(".motivo").val();
		    obs=$(".obs").val();
			desde=$(".desde").val();
			hasta=$(".hasta").val();
			empId=$(".empId").val();
			idopcion=$(".idopcion").val();
	//validacion de campo
		    validacion_desde=/^\d{4}\/\d{2}\/\d{2}$/;
			validacion_hasta=/^\d{4}\/\d{2}\/\d{2}$/;
			if(motivo==""){
				$(".motivo").focus();
				alert("Insertar motivo de ausencia");
				return false
				}else if(desde=="" || desde<fecha){
				$(".desde").focus();
				alert("Fecha de inicio no válida");
				return false;
			} else if (hasta == ""  || hasta<fecha) {
            $(".hasta").focus();
			alert("Fecha limite no válida");
            return false;
        }else{
			//$('#button').attr("enabled",true);
            $('.ajaxgif').removeClass('hide');
  var datos = 'motivo='+ motivo + '&obs=' + obs + '&desde=' + desde + '&hasta=' + hasta + "&empId="+empId +"&idopcion="+idopcion;
            $.ajax({
                type: "POST",
                url: "registros/addControl.php",
				data: datos,
				//dataType:'html',
                success: function() {
                    $('.ajaxgif').hide();
                    $('.msg').text('Registro de permiso completo!').addClass('msg_ok').animate({ 'right' : '130px' }, 300);  
					window.location="registros/log.php";
					//$(".motivo").val()="";
					//$(".obs").val()="";
					//$(".desde").val()="";
					//$(".hasta").val()="";	
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