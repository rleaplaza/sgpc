<?php 
session_start();
?>
<html>
<head><title>Registro de maquinaria solicitada</title>

<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableSolicitud").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
    <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param,param2) {
			//var idPerm = $(this).attr("tipoPerm");
			var idmaq = param;
			var idsol=param2;
			ajaxFace = new LightFace.Request({
				url: 'registros/setMaqProyecto.php',
				buttons: [
					{ title: 'Cerrar', event: function() { 
					                          this.close();
											  recargar(); },color:'blue' }
				],
				request: { 
					data: { 
						IDmaquinaria: idmaq || 'Id no almacenado',
						IDsolicitud:idsol || 'ID no almacenado',
						IDproyecto:document.id('idproy').value || 'Proyecto no almacenado'
					},
					method: 'post'
				},
				title: 'Registro de maquinaria a solicitud'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
		//
		var fun1 = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var nroSolicitud=param
			ajaxFace = new LightFace.Request({
				url: 'registros/cancelarSolicitud.php',
				buttons: [
					{ title: 'Cerrar', event: function() { 
					                          this.close();
											  recargar(); },color:'blue' }
				],
				request: { 
					data: { 
						NroSolicitud: nroSolicitud || 'Id no almacenado'
					},
					method: 'post'
				},
				title: 'Cancelación solicitud'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
		function recargar(){
			var int=self.setInterval("refresh()",5000);
			location.reload(true);
			}
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
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/cssEstado.css" rel="stylesheet" type="text/css">
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
	}else{
		header("location: ../index.php");
		}
?>

      <h2><legend>Maquinaria en alquiler</legend></h2>
        <img src="../images/maquinaria1.jpg" width="60" height="60" /><br>
       <table id="tableSolicitud" width="900" align="left">
      <thead>
            	<tr>
                    <th width="20"><label>Fecha de solicitud</label></th>
                    <th width="20"><label>Nro</label></th>
                    <th width="100"><label>Descripción</label></th>
                    <th width="130"><label>Solicitante</label></th>
                    <th width="20"><label>Cantidad solicitada</label></th>
                    <th width="20"><label>Subtotal</label></th>
                    <th width="60"><label>Iva 13</label></th>
                    <th width="60"><label>Total</label></th>
                    <th width="120"><label>Estado</label></th>
                    <th width="120"></th>
                    <th width="120"></th>
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
			#button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#093;
			border-radius:8px 8px 8px 8px;
				}
			#button:hover{
			background:#999;
			}
			#button1{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#F00;
			border-radius:8px 8px 8px 8px;
				}
			#button1:hover{
			background:#999;
			cursor:pointer;
			}
			</style>      
<?php
	$sql=$dbh->prepare("SELECT IDsolicitud, fechaSolicitud,nro_solicitud, m.descripcion, e.nombres, app, apm, cantidad_sol, subtotal, iva, total, s.estado, p.IDproyecto, m.IDmaquinaria
                        FROM empleado AS e, solicitud_maquinaria AS s, proyecto AS p, maquinaria AS m
                        WHERE e.IDempleado = s.IDempleado
                        AND s.IDproyecto = p.IDproyecto
                        AND s.IDmaquinaria = m.IDmaquinaria");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idsol=$row[0];
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td align="center"><?php echo $row[4]." ".$row[5]." ".$row[6];?></td>
     <td align="center"><?php echo $row[7];?></td>
     <td align="center"><?php echo $row[8];?></td>
     <td align="center"><?php echo $row[9];?></td>
     <td align="center"><?php echo $row[10];?></td>
     <td align="center"><?php if($row[11]=="Atendido")
	                          echo "<green>".$row[11]."</green>";
							  else if($row[11]=="Cancelado") 
							  echo "<red>".$row[11]."</red>";
							  else if($row[11]=="Pendiente")
							  echo "<yellow>".$row[11]."</yellow>"?></td>
     <td align="center">
      <input type="hidden" value="<?php echo $row[12];?>" id="idproy">
      <input type="button" onclick="fun('<?php echo $row[13];?>','<?php echo $row[0];?>'); return false;" class="submit classPermisos" value="Procesar solicitud" id="button"></td>
      <td><input type="button" onclick="fun1('<?php echo $row[2];?>');return false" class="submit classPermisos" value="Cancelar solicitud" id="button1"></td></tr>
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