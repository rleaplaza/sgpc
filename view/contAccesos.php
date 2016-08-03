<?php session_start();?>
<html>
<head><title>Contador de accesos</title>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableAccesos").dataTable({//captura el id de la tabla
				"sScrollY":"200px",//habilita el scroll vertical
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//archivo de traducción al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
<?php 
#Este programa se encarga de listar las cantidades de acceso realizadas por parte de los usuarios.
 try{
        require_once("../db/connect.php");//llama a la conexión de base de datos
		require_once("registros/regAuditoria.php");//archivo log de auditoría
if(isset($_SESSION["username"])){//verifica que la sesión exista
$user=$_SESSION["username"];
#consulta para recuperar el nombre del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
	$consulta->execute();//ejecuta la instrucción
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		#Despliegue de los nombre de menú, submeú y opción
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
			#almacena los campos del arreglo
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
		}
		require_once("consultas/mensajeAyuda.php");//llama al archivo mensaje de ayuda
		$idopcion=$_GET["idopcion"];//almacena al id de opción
		$mensaje=consultaMensaje($idopcion);//la variable invoca a la función de mensaje de ayuda y envía el id de opción
		?>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;//el título del tag img mostrará el mensaje de ayuda?>">
        <?php
	}
	else{
		header("location: ../index.php");
		}
		
	?>

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
      <h2><legend>Contador de accesos</legend></h2>
        <img src="../images/contador.jpg" width="50" height="50" />
        <a href="<?php echo "../reportes/administracion/repAccesos.php?user=$user";?>" target="_blank"><img src="../images/pdf_1.jpg" width="50" height="50" title="Exportar a PDF"/></a>
        <a href="../reportes/administracion/excel/repAccesosXls.php" target="_blank"><img src="../images/excel2013.png" width="50" height="50" title="Exportar a EXCEL"/></a>
       <table id="tableAccesos" width="1300" align="left">
      <thead>
            	<tr>
           <th><label>ID de acceso</label></th>
           <th><label>IP terminal de acceso</label></th>
           <th><label>Fecha</label></th>
           <th><label>Cantidad de accesos</label></th>
           <th><label>ID de usuario</label></th>
           <th><label>Username</label></th>
                </tr>
       </thead>
           <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
			</style>
<?php

   #consulta de la cantidad de accesos a la tabla ordenados por fecha descendente
	$sql=$dbh->prepare("select *from contadoraccesos order by fecha DESC");
	$sql->execute();
        if($sql->rowCount()>0){
           
        	foreach($sql->fetchAll() as $row){
        		?>
           <tr><td><?php echo($row["IDvisita"]);//campo id de acceso?></td>
  	       <td><?php echo($row["ip"]);//campo dirección ip?></td>
           <td><?php echo($row["fecha"]);//campo fecha?></td>
  	       <td><?php echo($row["num"]);//campo número de accesos realizados?></td>
  	       <td><?php echo($row["USR_UID"]);//campo id de usuario?></td>
           <?php $sql1=$dbh->prepare("select username from usuario where USR_UID=?");
		         $sql1->bindParam(1,$row["USR_UID"]);
				 $sql1->execute();
				 $fila=$sql1->fetch();
				 ?>
             <td><?php echo($fila["username"]);?></td>
           </tr>
            <?php
        }?>
        </table>
        <?php
		}
        else{
        	echo("<label>Log de accesos vacio</label>.");

        }
?>
     
<?php
}
else{
	header("location: ../index.php");//redirige al login
}
    }catch(PDOException $e){
          echo "Error inesperado".$e->getMessage();//genera una excepción en caso de que la conexión falle
    }
         

?>