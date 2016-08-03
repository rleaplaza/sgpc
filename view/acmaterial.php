<?php session_start();#función de manejo de sesiones?>
<html>
<head><title>Registro de avance por material</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({
				"sScrollY":"250px",//define el scroll vertivcal
				"bPaginate":true,//habilita la paginación
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"//traducción al idioma espaniol
					}
				});
        });
		function recargar(str){
			var int=self.setInterval("refresh()",5000);
			location.reload(true);
			}  
        </script>
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
if(isset($_SESSION["username"])){ #valida que si la sesión exista el usuario pueda ver el registro, caso contrario envía a la página login
	try{ #try catch para el manejo de excepciones
		#llama a los archivos externos para el programa
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	#consulta PDO para llamar al nombre del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();#ejecuta la consulta
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];#captura del id de la opción
		$row=$consulta->fetch();#transforma el registro en un arreglo para desplegar los campos
		echo("<p align=center><label>".$row["nombremenu"]."</label><br> ");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion); #función que registra el log de auditoría
		}
		else{
			header("location: ../index.php");
			}
	}
	if(isset($_GET["idproyecto"])){
	$idproyecto=$_GET["idproyecto"];#almacena el ID del proyecto
	$idopcion=$_GET["idopcion"];
?>      
        <img src="../images/tareas.jpg" width="30" height="30" />
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="25" width="25" title="Para realizar consultas de avances, presionar el botón Informar avance para cargar el formulario y llenar el avance, para consultar informe por trabajador, presionar el botón consultar informe para desplegar el listado de avances, para imprimir en PDF, presionar la imagen respectiva">
        <form method="get">
        <input type="hidden" value="<?php echo $idproyecto;?>" name="proyecto">
        <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
        <input type="submit" id="button" value="Salir" onClick="this.form.action='listActAvance.php'">
        <input type="button" id="button" onClick="recargar()" value="Actualizar">
        </form>
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de uso</label></th>
                    <th><label>Material</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Cantidad entregada</label></th>
                    <th><label>Cantidad utilizada</label></th>
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
			background:#FC3;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#666;
					}
			</style>
<?php
if(isset($_GET["idactividad"])){
	$user=$_SESSION["username"];
$idactividad=$_GET["idactividad"];#captura del identificador de la actividad
#consulta PDO para mostrar el registro de trabajadores asignados  a la actividad
	$sql=$dbh->prepare("SELECT mat.IDmaterial,fecAvance,mat.descripcion, mat.unidad, am.cantidad_programada,cant_solicitada, cantidad_utilizada
                        FROM actividad AS a, material AS mat, actividad_material AS am
                        WHERE a.IDactividad = am.IDactividad
                        AND am.IDmaterial = mat.IDmaterial
						and a.IDactividad=?");
	$sql->bindParam(1,$idactividad);#enlace al id de actividad para ejecutar la consulta
	$sql->execute(); #ejecuta la consulta
	#arreglo para desplegar el registro en cuestión
	$cantidadusada=0;
	#el resultado se devolverá en el siguiente arreglo desplegado en el datatable
	foreach($sql->fetchAll() as $row){
		$unidadTrabajo=$row[3];#almacena el índice como variable unidad de trabajo
		#consulta PDO para capturar la cantidad de material utilizado
		$cantidadsol=$row[5];
		$cantidadusada=$row[6];
		$cantReal=$row[4];
		   ?>
     <tr>
     <td align="center"><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[4]." ".$row[3];?></td>
     <td width="80" align="center"><?php echo $cantidadsol." ".$row[3];?></td>
      <td width="80" align="center"><?php echo $cantidadusada." ".$row[3];?></td>
     <td align="center"><button id="button" onclick="editInformeMat('<?php echo $idactividad;?>','<?php echo $row[0]?>')">Informar uso</button></td>
     <td><a href="<?php echo "../reportes/proyectos/repMatUsado.php?idactividad=$idactividad&idmaterial=$row[0]&descripcion=$row[2]&cantAsignada=$cantidadsol&cantUsada=$cantidadusada&unidad=$row[3]&idproyecto=$idproyecto&user=$user";?>" target="_blank"><img src="../images/pdf.jpg" height="30" width="30" title="Imprimir informe en PDF"></a></td>
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
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage(); #genera una excepción en caso de algún error inesperado
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