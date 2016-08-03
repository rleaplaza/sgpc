<html>
<head>
<meta charset="utf-8">
<!--Este programa despliega el formulario de inicio de sesión donde el usuario deberá ingresar su nombre de usuario y password-->
<!-- Define la imagen como icono para el tab del navegador-->
<link href="images/favicon.ico" type="image/x-icon" rel="shortcut icon" />
</head>
<body>
<!--Llamada al archivo jquery-->
<script type="text/javascript" src="js/jquery.min.js"></script>

<script>
function chk_ajax_login_with_php(){//función para realizar el login dinámico del usuario
  var username=document.getElementById("username").value;//captura el username
  var password=document.getElementById("password").value;//captura el password
  var contador=0;
    var params = "username="+username+"&password="+password;//une los campos en una variable
		   var url = "authentication";//url destino authentication.php
				$.ajax({//función ajax para procesar el login desde el cliente
		            type: 'POST',//método post
				    url: url,//guarda la url destino
				    dataType: 'html',//convierte a html
					data: params,//guarda la variable de los parámetros de login
					beforeSend: function() {//procesa la información
				document.getElementById("status").innerHTML= 'autenticando...' + '<img src="images/loader.gif" height="40" width="40">' ;//almacena la sintexis html
						},
					complete: function() {//completa para llamar a una función anónima
										},
					success: function(html) {//en caso de haber procesado el login devuelve el html a la función					   		 //carga el contenido html
					document.getElementById("status").innerHTML= html;
					if(html=="Autenticado"){//mensaje de autenticado
									  //direcciona a la página principal
						window.location = "view/main"
					}else{//en caso de fallar el login despliega el mensaje
					if(html=="Credenciales invalidas");
						limpiar();//llama a la función limpiar
						enfocar();
						}
									 
							   }
					   });  
}
function limpiar(){//función para limpiar el formulario si los datos de login fallan
	var username;//variable de usuario
	username=document.getElementById("username").value="";
	document.getElementById("password").value="";
	}
function enfocar(){
	var username=document.getElementById("username").focus();
	}
</script>
<!-- Estilos para el formulario como margen, cuarto del document html, fuentes, alineación de texto-->
<link href="css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
* { margin:0 auto;
		    padding:0;
		}
		html { background:#9990; }
		body{    margin:1px auto;
    background:#999;
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
	label{ font:Verdana, Geneva, sans-serif;
		    color:#00C;
	         }
     legend{font:Verdana, Geneva, sans-serif;
	   color:#0CF;
	   size:auto;
      }
     .enlace{
	 text-decoration:none;
	 }
	 .enlace:hover{
		 color:#009;
		 text-decoration:underline;
		 }
</style>
<title>Plataforma informática de gestión de proyectos de carreteras</title>
<body>
<table width="1347">
<th>
<tr>
<td>
<?php require_once("principal.html");//llama al archivo para conocer el rubro de la empresa,
// misión y visión?>
</td>
</tr>
</th>
</table>

<!--El div almacena el formulario donde se despliega el nombre de usuario y password, la imagen de login.jpg-->
<div id="logindiv">
<table colspan="10"><th colspan="4"align="left"><td bgcolor="#0033CC"><img src="images/login.jpg" height="60" width="150"></td></th></table><br>
<legend>Por favor, ingrese sus credenciales en el formulario</legend>
 <input name="username" id="username" type="text" class="textbox" autofocus maxlength="20" required placeholder="Usuario">
  <input name="password" id="password" type="password" class="textbox" maxlength="20" required placeholder="Contraseña">
<input value="INICIAR SESIÓN" name="login" class="submit" type="submit" onclick='chk_ajax_login_with_php();' id="submit"><br>
<a href="seguridad/password" class="enlace"><legend>Olvidó su contraseña?</legend></a>
<legend><p align="center">Copyright 2014 - 2015</p></legend>
<div id='status'></div>
</div>	
</body>
</html>




