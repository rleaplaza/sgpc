<?php
session_start();
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/ajaxgr.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
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
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
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
		else{
			header("location: ../index.php");
			}
	}
?>
        <img src="../images/tareas.jpg" width="20" height="20" /><img src="../images/precios.jpg" width="30" height="30" /><img src="../images/ayuda.jpg" height="20" width="20" title="Para imprimir informes de precios unitarios, presione los iconos correspondientes debajo de la lista desplegable de fases"><br>
        <form method="post">
        <label>Seleccione una fase</label><select name="fase" class="fase">
        <?php 
		$consulta=$dbh->prepare("select *from fase order by nombre asc");
		$consulta->execute();
		if($consulta->rowCount()>0){
			foreach($consulta->fetchAll() as $reg){
				?>
                <option value="<?php echo $reg[0];?>"><?php echo $reg[3];?>
                <?php
				}
			}
		?>
        </select><br>
        <input type="image" name="envia" src="../images/html.png" height="40" width="40" onClick="this.form.action='precios.php'" formtarget="_blank" title="abrir registro en html">
        <input type="image" name="sendGr" src="../images/grafico1.jpg" height="40" width="40" onClick="this.form.action='../reportes/proyectos/grPreciospie.php'" formtarget="_blank">
        </form>
        <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fase</label></th> 
                    <th><label>Actividad</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Precio unitario</label></th>
                    <th><label>Costo Total</label></th>
                    <th><label>Desde - Hasta</label></th>
                    <th></th>
                </tr>
       </thead>
           <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
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
			background:#00F;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#09F;
					}
			</style>
<?php
#captura del id del proyecto
$idproyecto=$_POST["proyecto"];
#consulta para listar las actividades correspondientes al proyecto
	$sql=$dbh->prepare("SELECT IDactividad, fase.nombre, nombreActividad, unidades, cantidad, precioUnitarioBS,costo_total,fechaRealizacion, fechaFin
                        FROM actividad, subfase, fase, proyecto
                        WHERE actividad.IDsubfase = subfase.IDsubfase
                        AND subfase.IDfase = fase.IDfase
                        AND fase.IDproyecto = proyecto.IDproyecto
						and proyecto.IDproyecto=?
						order by actividad.hraRegistro");
	$sql->bindParam(1,$idproyecto);//enlaza al id del proyecto
	$sql->execute();//ejecuta la instrucción
	$dbh->query("SET NAMES UTF8");//establece la codificación utf8 para los registros
	foreach($sql->fetchAll() as $row){//devuelve el resultado en el arreglo
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[4]." ".$row[3];?></td>
     <td><?php echo $row[5]." Bs";?></td>
     <td><?php echo $row[6]." Bs";?></td>
     <td><?php echo $row[7]."-".$row[8];?></td>
     <td><button id="button" onClick="ConsultaPrecio('<?php echo $row[0];?>')">Consultar detalle</button></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
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