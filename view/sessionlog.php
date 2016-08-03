<?php session_start();//inicio de la sesión?>
<html>
<head><title>Log de sesiones</title>
<?php 
 try{
        require_once("../db/connect.php");
		require_once("registros/regAuditoria.php");
		require_once("consultas/mensajeAyuda.php");
if(isset($_SESSION["username"])){
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		$mensaje=consultaMensaje($_GET["idopcion"]);
	}
	}
		else{
			header("location: ../index.php");
			}
	?>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>



<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableSesion").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"}
				});
        });
        </script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/reveal.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.idealforms.min.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>

      <h2><legend>Ayuda del sistema</legend><img src="../images/ayuda.jpg" width="20" height="20" title="<?php echo $mensaje;?>"></h2><br>
        <img src="../images/sesion.jpg" width="40" height="40" />
        <a href="../reportes/administracion/repSesiones.php" target="_blank"><img src="../images/pdf_1.jpg" width="40" height="40" title="Imprimir en PDF"/></a>
       <a href="../reportes/administracion/excel/repSesionesXls.php" target="_blank"><img src="../images/excel2013.png" width="40" height="40" title="Imprimir en EXCEL"/></a>
       <table id="tableSesion" width="1200" align="left">
      <thead>
            	<tr>
           <th><label>ID de sesión</label></th>
           <th><label>username</label></th>
           <th><label>Fecha de inicio</label></th>
           <th><label>Fecha de fin</label></th>
           <th><label>Hora de inicio</label></th>
           <th><label>Hora de fin</label></th>
           <th><label>Direccion IP de acceso</label></th>
                </tr>
       </thead>
           <style>
		     text{
				 font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  font-size:18px;
				 }
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
			</style>
<?php

   
	$sql=$dbh->prepare("select *from sesion, usuario where usuario.USR_UID=sesion.USR_UID order by fecInicio DESC");
	$sql->execute();
        if($sql->rowCount()>0){
           
        	foreach($sql->fetchAll() as $row){
        		?>
           <tr>
  	       <td align="center"><?php echo(sha1($row["IDsession"]));?></td>
           <td align="center"><?php echo($row["username"]);?></td>
  	       <td align="center"><?php echo($row["fecInicio"]);?></td>
  	       <td align="center"><?php echo($row["fecFin"]);?></td>
  	       <td align="center"><?php echo($row["hraInicio"]);?></td>
  	       <td align="center"><?php echo($row["hraFin"]);?></td>
  	       <td align="center"><?php echo($row["dirIp"]);?></td></tr>
            <?php
        }
		?>
        </table>
        <?php
		}
        else{
        	echo("<label>Log de sesiones vacio</label>.");

        }
}
else{
	header("location: ../index.php");
}
    }catch(PDOException $e){
          echo "Error inesperado".$e->getMessage();
    }
         

?>