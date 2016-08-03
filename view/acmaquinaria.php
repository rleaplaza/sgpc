<?php 
#este programa se encarga de listar utilidad de maquinaria en actividades
session_start();//función de inicio de sesión
?>
<html>
<head><title>Avance por maquinaria</title>
<meta charset="utf-8">
<!-- Llamada a los archivos javascript-->
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//propiedades para el datatables
				"sScrollY":"250px",//scroll vertical
				"bPaginate":true,//paginación
				"oLanguage":{//Traducción al idioma espaniol
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
		function recargar(str){
			var int=self.setInterval("refresh()",5000);
			location.reload(true);
			} 
        </script>
        <!-- El archivo ajaxgr generá las ventanas modales-->
        <script type="text/javascript" src="../js/ajaxgr.js"></script>

<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	try{
		#llamada a los archivos de conexión y programa de log de auditoría
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	#conaulta PDO para seleccionar el programa actual de navegación
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();//devuelve el resutado en un arreglo
		//Mensaje que indica el programa donde se está navagando
		echo("<p align=center><label>".$row["nombremenu"]."</label><br> ");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){//asigna a las variables
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		#función que envía los parámetros del menú para registrarlos en el log de auditoría
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		else{
			header("location: ../index.php");
			}
	}
	if(isset($_GET["idproyecto"])){
	$idproyecto=$_GET["idproyecto"];
?>
        <img src="../images/tareas.jpg" width="30" height="30" />
        <form method="get">
        <input type="hidden" value="<?php echo $idproyecto;?>" name="proyecto">
        <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
        <input type="submit" id="button" value="Salir" onClick="this.form.action='listActAvance.php'">
        <input type="button" id="button" onClick="recargar()" value="Actualizar">
        </form>
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Última fecha de uso</label></th>
                    <th><label>Equipamiento</label></th>
                    <th><label>Cantidad asignada</label></th>
                    <th><label>Cantidad usada</label></th>
                    <th><label>Horas máquina</label></th>
                    <th></th>
                    <th></th>
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
				
		    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#093;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#666;
					}
			</style>
<?php
if(isset($_GET["idactividad"])){
	$user=$_SESSION["username"];
$idactividad=$_GET["idactividad"];//captura el ID de actividad
#consulta PDO que se desplegará en el listado
	$sql=$dbh->prepare("SELECT m.IDmaquinaria, m.descripcion, am.cant_asignada, am.cantidad_usada, am.unidad, am.total_horas, precio_productivo, am.costo_total, fechaAvance
FROM maquinaria AS m, actividad_maquinaria AS am, actividad AS a
WHERE m.IDmaquinaria = am.IDmaquinaria
AND am.IDactividad = a.IDactividad
						and a.IDactividad=?");
	$sql->bindParam(1,$idactividad);//enlaza al parámetro ID de actividad
	$sql->execute(); //ejecuta la consulta
	  $avance=0;
	#arreglo que desplegará el registro requreido
	foreach($sql->fetchAll() as $row){
		$nombre=$row[1];//asignación de variables del arreglo
		$IDmaquinaria=$row[0];
		$avance=$row[2];
		   ?>
     <tr>
     <td><?php echo $row[8];?></td>
     <td><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[3];?></td>
     <td align="center"><?php echo $row[5]." ".$row[4];?></td>
     <td align="center"><button id="button" onclick="editAvanceMaq('<?php echo $idactividad;?>','<?php echo $IDmaquinaria;?>','<?php echo $nombre;?>')">Informar uso</button></td>
     <td align="center"><a href="<?php echo "../reportes/proyectos/repAvanceMaq.php?idactividad=$idactividad&idmaquinaria=$IDmaquinaria&descripcion=$nombre&avance=$avance&user=$user";?>" target="_blank"><img src="../images/pdf.jpg" height="40" width="40" title="Imprimir en PDF"></a></td>
 </tr>
		<?php
		}
		?>
</table>
        <?php
}else{
	header("location: ../index.php");
	}
	}else{
		header("location: ../index.php");
		}
	}catch(PDOException $e){//genera una excepción en caso de errores inesperados
		echo "Error inesperado ".$e->getMessage();
		}
?>	
<?php
}
else
{ header("location: ../index.php");
	}
?>
</body>
</html>