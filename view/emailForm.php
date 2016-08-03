<html>
<head>
<meta charset="utf-8">
<!--Este programa despliega el formulario de inicio de sesión donde el usuario deberá ingresar su nombre de usuario y password-->
<!-- Define la imagen como icono para el tab del navegador-->
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<!--Llamada al archivo jquery-->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script>
function enviaPassword(){//función para realizar el envío de solicitud de password
  var username=document.getElementById("username").value;//captura el username
  var email=document.getElementById("email").value;//captura el password 
    var params = "username="+username+"&email="+email;//une los campos en una variable
		   var url = "saveEmailconf";//url destino
		      limpiar();
				$.ajax({//función ajax para procesar el login desde el cliente
							   type: 'POST',//método post
							   url: url,//guarda la url destino
							   dataType: 'html',//convierte a html
							   data: params,//guarda la variable de los parámetros de login
							   beforeSend: function() {//procesa la información
				document.getElementById("status").innerHTML= 'Guardando configuración, por favor espere...' + '<img src="../images/loader.gif" height="40" width="40">' ;//almacena la sintexis html
										 },
							   complete: function() {//completa para llamar a una función anónima
										
							   },
							   success: function(html) {//en caso de haber procesaro el login devuelve el html a la función
							   		 //carga el contenido html
									 document.getElementById("status").innerHTML= html;
									 if(html=="Enviado"){//mensaje de autenticado
									  //direcciona a la página principal
									  window.location = "confirmacion.php"
									 }
							   }
					   });  
}
function limpiar(){
	document.getElementById("username").value="";
	document.getElementById("email").value="";
	document.getElementById("username").focus();
	}
$(document).ready(function(){
	$("#chkauth").change(function(){
		if(this.checked){
			$("#auth").fadeIn('slow');
			$("#auth").attr('required');
		}else if(!this.checked){
			$("#auth").fadeOut('slow');
			$("#auth").removeAttr('required');
			}
		});
	});
</script>
<!-- Estilos para el formulario como margen, cuarto del document html, fuentes, alineación de texto-->

<style type="text/css">
* { margin:0 auto;
		    padding:0;
		}
		html { background:#9990; }
		body{    margin:1px auto;
    background:#CCC;
}
		div#menu {
		margin:0px 20 10 0px;
    position:absolute;
		}
		div#copyright {
    font:20px 'Trebuchet MS';
    color:#fff;
    text-align:center;
    clear:left;
    position:absolute;
    top:10px;
    width:10px;
		}
		div#copyright a { color:#425B37B; }
		div#copyright a:hover { color:#fff; }
		p{ font-family:Arial, Helvetica, sans-serif;
		color:#03F;
		
			}
	   label{ font:Verdana;
		      color:#00C;
	        }
       legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
 }
</style>
<title>Serco Bolivia</title>
<body>
<!--El div almacena el formulario donde se despliega el nombre de usuario y password, la imagen de login.jpg-->
<div id="logindiv">
<p align="center"><label>Configuración de Email</label></p>
<p align=center><img src="../images/emailconf.jpg" height="40" width="80" id="img" style="alignment-adjust:central"></p><br>
  <input name="server" id="server" type="text" class="textbox" autofocus maxlength="20" placeholder="servidor de correo">
  <input name="puerto" id="puerto" type="text" class="textbox" maxlength="3" placeholder="puerto">
  Usar conexión segura
  <input type="radio" name="rbconf" id="rbno" style="alignment-adjust:auto">NO
  <input type="radio" name="rbconf" id="rbssl">SSL
  <input type="radio" name="rbconf" id="rbtls">TLS<br>
  Requiere autenticación<input type="checkbox" id="chkauth" name="chkauth" onChange="showPassword()">
  <input name="usuario" id="usuario" type="text" class="textbox" autofocus maxlength="20" placeholder="Usuario">
  <input type="password" name="auth" id="auth" placeholder="*******" maxlenght="40" style="display:none;">
<input value="Guardar Cambios" name="send" class="submit1" type="submit" onclick='enviaPassword();'>

<div id='status'></div>
</div>	
</body>
</html>
