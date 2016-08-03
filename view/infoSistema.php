<?php session_start();//función de inicio de sesión
#Este programa despliega el formulario de edición de cuenta de usuario como password y correor electrónico
?>
<html>
<head><title>Edicion de cuenta de usuario</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<style>
            label{
			  font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
		      color:#00C;
			  font-size:12px;
	         }
	         legend{
			  font:Verdana, Geneva, sans-serif;
	          color:#009;
	          size:auto;
				 }
			</style>
</head>
<body>

<?php
if(isset($_SESSION["username"])){//verifica si existe la sesión
require_once("../db/connect.php");
	try{
		require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	#consulta el programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
		}
		
	}
	else{
		header("location: ../index.php");//redirige al login
		}
		$sql=$dbh->prepare("show variables like '%version'");
		$sql->execute();
		$query=$dbh->prepare("show databases like 'dbserco'");
		$query->execute();
		$fila=$query->fetch();
		$db=$fila[0];
		?>
        <img src="../images/information.jpg" width="30" height="30"/>
        <fieldset>
        <form>
        <legend>Información del sistema</legend>
        <input type="image" src="../images/pdf_1.jpg" height="30" width="30" onClick="this.form.action='../reportes/administracion/infoSistema.php'">
        <table>
        <tr><td><label>Servidor</label></td><td><?php echo $_SERVER["SERVER_NAME"];?></td></tr>
        <tr><td><label>Zona horaria</label></td><td><?php echo date_default_timezone_get();?></td></tr>
        <tr><td><label>Software</label></td><td><?php echo $_SERVER["SERVER_SOFTWARE"];?></td></tr>
        <tr><td><label>Versión de php</label></td><td><?php echo phpversion();?></td></tr>
        <tr><td><label>IP de servidor</label></td><td><?php echo $_SERVER["SERVER_ADDR"];?></td></tr>
        <tr><td><label>Base de datos</label></td><td><?php echo $db;?></td></tr>
        <tr><td><label>Sistema operativo</label></td><td><?php echo php_uname();?></td></tr>
        <tr><td><label>Protocolo de servidor</label></td><td><?php echo $_SERVER["SERVER_PROTOCOL"];?></td></tr>
        <tr><td><label>Puerto de servidor</label></td><td><?php echo $_SERVER["SERVER_PORT"];?></td></tr>
        <tr><td><label>Navegador de usuario</label></td><td><?php echo $_SERVER["HTTP_USER_AGENT"];?></td></tr>
        </table>
        </form>
        </fieldset>
        <?php
		}catch(PDOException $e){
			echo("Error inesperado ".$e->getMessage());//genera la excepción
			}
	}
	else{
		header("location: ../../index.php");//redirige al login
		}
?>
</body>
</html>