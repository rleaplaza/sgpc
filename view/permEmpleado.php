<?php session_start();//función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--Los archivos jquery y jquery ui mejoran la experiencia de usuario, el archivo tabber se encarga de realizar la generación de pestañas -->
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<title>Control de permisos</title>

<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
             <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
		      </style>
             <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
             <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
             <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript"></script>
</head>

<body>
 
<?php
if(isset($_SESSION["username"])){//valida la sesión
	if(isset($_GET["idopcion"])){//valida la existencia de la opción
		$idopcion=$_GET["idopcion"];//asigna el id opción a la variable
		try{ require_once("../db/connect.php");//llamada a la conexión a base de datos
		require_once("registros/regAuditoria.php");//llamada al log de auditoría
		#Consulta para el programa donde se está navegando
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
         $consulta->bindParam(1,$idopcion);
	     $consulta->execute();
if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
  }
  ?>
  <?php
  $sql=$dbh->prepare("select empleado.CI, usuario.CI from usuario, empleado where usuario.CI=empleado.CI and username=?");
  $sql->bindParam(1,$_SESSION["username"]);
  $sql->execute();
  if($sql->rowCount()>0){
  $row=$sql->fetch();
  ?>
 <div class="tabber" id="tab2">
 <div class="tabbertab">
 <h2><label>PERMISOS POR AUSENCIA</label></h2>
<fieldset>
 <legend>Formulario de control</legend>
  <form method="post" class="usuario" id="formulario" name="form">
  <table>
  <div><tr><td><label>USER ID</label></td><td><input type="text" id="userId" class="userId" name="userId" value="<?php echo $row[1];?>" disabled="disabled"></td></tr></div>
  <div><tr><td><label>MOTIVO DE AUSENCIA</label></td><td><input type="text" id="motivo" class="motivo" name="motivo"></td></tr></div>
  <div><tr><td><label>OBSERVACIONES</label></td><td><textarea name="obs" id="obs" class="obs" rows="6" cols="30"></textarea></td></tr></div>
  <div><tr><td><label>TIEMPO DE AUSENCIA DESDE</label></td><td><input type="text" id="Datepicker1" class="desde" name="desde"contenteditable="false">
  </td></div>
  <div><tr><td><label>HASTA</label></td><td><input type="text" id="DatePicker2" class="hasta" name="hasta" contenteditable="false"></td></tr></div>
 <input type="hidden" name="empId"  id="empId" class="empId" value="<?php echo $row[0];?>">
 <input type="hidden" name="idopcion" id="idopcion" class="idopcion" value="<?php echo $idopcion?>">
 <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button id="button" class="boton_envio">REGISTRAR CONTROL</button></td></tr>
 </div>
  </table>
  </form>
  </fieldset>
  <script type="text/javascript" src="../js/saveControl.js"></script>
  </div>
  <?php
  }else{
	  echo "<label>Su informacion aun no se ha registrado en el sistema, consulte con el administrador general</label>";
	  }
  $query=$dbh->prepare("SELECT pagina_opcion.nombre, pagina_opcion.url
                     FROM opcion, pagina_opcion, permiso_pagina, usuario
                     WHERE opcion.IDopcion = pagina_opcion.IDopcion
                      AND pagina_opcion.IDpagina = permiso_pagina.IDpagina
                      AND permiso_pagina.USR_UID = usuario.USR_UID
                      AND username=?
                      AND opcion.IDopcion=?
                      and permiso_pagina.estado='activo'
					  order by pagina_opcion.nombre ASC");
	$query->bindParam(1,$_SESSION["username"]);
	$query->bindParam(2,$idopcion);
	$query->execute();
	if($query->rowCount()>0){
		foreach($query->fetchAll() as $fila){
  ?>
  <div class="tabbertab">
       <h2><legend><?php echo($fila[0]);?></legend></h2>
       <?php require_once($fila[1]);?>
    </div>
    <?php
		}
	}
	?>
  
  </div>
			<?php
			}catch(PDOException $e){
				echo "Error inesperado:".$e->getMessage();
				}
		}
		else
		{ header("location: ../index.php");
			}
	}
	else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#Datepicker1" ).datepicker(); 
	$( "#Datepicker1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	$("#DatePicker2").datepicker();
	$("#DatePicker2").datepicker('option',{dateFormat:'yy-mm-dd'});
});
            </script>
</body>
</html>