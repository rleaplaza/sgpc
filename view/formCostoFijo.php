<?php session_start();//función de inicio de sesión
#Este programa se encarga de mostrar el formulario de registro de costos fijos?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   #button{ font-wight:bold;
			   cursor:pointer;
			   padding:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#06F;
			   border-radius:8px 8px 8px 8px;
			   color:#FFF;
		      }
		 #button:hover{
				background:#00F;
			}
	   </style>
       <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){//captura el id del botón
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightface
					url: 'registros/addCosto.php',//url destino
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura de las variables del formulario
						    Desc:document.id('desc').value || 'nombre no agregado',
							Valor:document.id('valor').value || 'cargo no ingresado'
						},
						method: 'post'
					},
					title: 'Registro de costos fijos'//título de la ventana
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia del nombre de usuario
	require_once("../db/connect.php");//conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al log de auditoría
	#consulta para el programa donde se está navegando
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		?>
        <img src="../images/costos.jpg" height="40" width="40"><br>
        <input type="submit" value="VOLVER AL FORMULARIO"  onClick="history.back()" id="button">
        <form method="post">
        <input type="submit" value="CONSULTAR LISTADO" id="button" onClick="this.form.action='listCostos.php'" formtarget="_blank">
        </form>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Llenar el formulario con la descripción y el valor de costo">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <fieldset>
    <legend>FORMULARIO DE COSTOS FIJOS</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" id="desc" class="desc" rows="6" cols="30"></textarea></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Valor de costo Bs</label></td><td><input type="text" name="valor" id="valor" class="valor" placeholder="5.00" maxlength="10"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>