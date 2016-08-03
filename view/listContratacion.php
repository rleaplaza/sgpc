<?php 
session_start();
?>
<html>
<head><title>Registro de cargos solicitados</title>

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
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idtrabajador = param;
			ajaxFace = new LightFace.Request({
				url: 'registros/ConfContrato.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						cedula: idtrabajador || 'Id de rol no ingresado',
						IDproy:document.id('idproyecto').value || 'ID de proyecto no capturado'
					},
					method: 'post'
				},
				title: 'Confirmación de contrato'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
    <script type"text/javascript">
//Activar permiso
		var fun1 = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idtrabajador = param;
			ajaxFace = new LightFace.Request({
				url: 'registros/RejectContrato.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						cedula: idtrabajador || 'Id de rol no ingresado',
						IDproy:document.id('idproyecto').value || 'ID de proyecto no capturado'
					},
					method: 'post'
				},
				title: 'Rechazo de contrato'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
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
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	
?>

      <h2><legend>CONFIRMACIÓN DE CONTRATO PARA TRABAJADORES</legend></h2>
        <img src="../images/cargoManoobra.jpg" width="60" height="60" /><br>
       <table id="tableSolicitud" width="900" align="left">
      <thead>
            	<tr> 
                    <th><label>Cargo</label></th>
                    <th><label>Cantidad solicitada</label></th>
                    <th><label>Fecha de solicitud</label></th>
                    <th><label>Estado</label></th>
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
			color:#093;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
				}
				#button:hover{
				background:#ddd;
					}
					#button1{
				font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#F00;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
				}
				#button1:hover{
				background:#ddd;
					}
			</style>
    <input type="submit" value="Volver al formulario de proyectos" onClick='history.back();' id="button"> <br>      
<?php
if(isset($_POST["proyecto"])){
  $idproyecto=$_POST["proyecto"];
  $consulta=$dbh->prepare("select *from proyecto where IDproyecto=?");
  $consulta->bindParam(1,$idproyecto);
  $consulta->execute();
  $fila=$consulta->fetch();
   ?>
   <label>Solicitud para el proyecto :  <?php echo $fila["nombre"]; ?></label>
   <?php
	$sql=$dbh->prepare("SELECT c.nombre, cantidad_contratada,fechaSolicitud, hraSolicitud, s.estado
                        FROM cargomanodeobra AS c, proyecto AS p, solicita AS s
                        WHERE c.IDcargoM = s.IDcargo_M
                        AND s.IDproyecto = p.IDproyecto
                        AND s.estado = 'Atendido'
                        AND p.IDproyecto = ?
                        ORDER BY c.nombre ASC ");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idtrabajador=$row[0];
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td align="center"><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[2]." ".$row[3];?></td>
     <td align="center"><?php echo $row[4];?></td>
     </tr>
		<?php
		}
		?>
</table>
        <?php
}else{
	header("location: ../index.php");
	}
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
