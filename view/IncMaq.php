<?php 
session_start();
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
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
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
    <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('button1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addIncMaq.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						IDproyecto:document.id('proyecto').value || 'ID de proyecto no almacenado',
						IDplan:document.id('idplan').value || 'ID de planificación no almacenado',
						},
						method: 'post'
					},
					title: 'Incorporación de maquinaria y equipos'
				}).open();
				
			});
			
		});    
</script>

    <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('button2').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaIncMaq.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						IDproyecto:document.id('proyecto').value || 'ID de proyecto no almacenado',
						IDplan:document.id('idplan').value || 'ID de planificación no almacenado',
						},
						method: 'post'
					},
					title: 'Consulta de incorporación de equipos'
				}).open();
				
			});
			
		});    
</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
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
			color:#093;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
			#button1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button1:hover{
					background:#ddd;
					}
					#button2{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button2:hover{
					background:#ddd;
					}
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
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<label>Menu: <b>".$row["nombremenu"]."</b></label> ");
		echo("<label>Submenu: <b>". $row["nombresubmenu"]."</b></label> ");
		echo("<label>Opcion: <b>".$row["nombreopcion"]."</b></label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		else{
			header("location: ../index.php");
			}
	}
	$proyecto=$_POST["proyecto"];
	$query=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	$query->bindParam(1,$proyecto);
	$query->execute();
	$reg=$query->fetch();
	$proy=$reg[0];
	
	#id de planeacion 
	$consulta=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is Null");
    $consulta->bindParam(1,$proyecto);
    $consulta->execute();
    $result=$consulta->fetch();
    $uidplan=$result[0];
?>
  <img src="../images/maquinaria1.jpg" width="30" height="30" /><br>
<label>Proyecto: </label><?php echo $proy;?>

      <h2><legend>ALMACÉN DE MAQUINARIA</legend></h2>
      <input type="submit" id="button" value="VOLVER AL FORMULARIO" onClick="history.back();">
       <input type="hidden" value="<?php echo $uidplan;?>" id="idplan">
     <input type="hidden" value="<?php echo $proyecto;?>" id="proyecto">
      <input type="button" id="button1" value="INCORPORAR A PROYECTO">
       <input type="button" id="button2" value="CONSULTAR INCORPORACIÓN">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Descripción</label></th>
                    <th><label>Unidad</label></th>
                    <th><label>Cantidad</label></th>
                    <th><label>Proveedor</label></th>
                </tr>
       </thead>
<?php
#consulta del uid de la planificación del proyecto


#consulta del listado de maquinaria a incorporar en el proyecto
	$sql=$dbh->prepare("SELECT IDmaquinaria,descripcion, unidad, cantidad_disponible, empProveedora
                        FROM maquinaria, proveedor
                        WHERE maquinaria.IDproveedor = proveedor.IDproveedor
                        AND cantidad_disponible >0");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td></tr>
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