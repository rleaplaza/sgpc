<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de módulos</title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function() {	
	$('#submenu').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var submenu = $(this).val();		
		var dataString = 'submenu='+submenu;
		
		$.ajax({
            type: "POST",
            url: "consultas/subMenudisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script>
 <style>
       label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
		     }
			  #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
	     #button:hover{
			background:#ddd;
			}
	    </style> 
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	if(isset($_GET["idmenu"])){
		$idmenu=$_GET["idmenu"];
	?>
    <input type="submit" value='Volver a listado de submenús' onClick='history.back();' id="button">
    <fieldset>
    <legend>Formulario de Submenus del sistema</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>Codigo de Módulo:</label></td><td><input type="text" id="modulo" class="modulo" name="modulo" disabled="disabled" value="<?php echo $idmenu;?>"/></td></tr></div>
    <div><tr><td><label>Nombre de submenú:</label></td><td><input type="text" id="submenu" class="submenu" name="submenu" placeholder="PROYECTOS" maxlength="30" /></td><div id="Info"></div></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoSubMenu.js"></script>
    <?php
	}else{
		header("location: ../index.php");
		}
	}else{
		header("location: ../index.php");
		}
?>

</body>
</html>