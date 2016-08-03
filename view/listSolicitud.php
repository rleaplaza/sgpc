<?php 
session_start();
?>
<html>
<head><title>Registro de cargos solicitados</title>

<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
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
			var ci = param;
			ajaxFace = new LightFace.Request({
				url: 'consultas/consultaSolicitante.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						cedula: ci || 'Id de rol no ingresado',
					},
					method: 'post'
				},
				title: 'Consulta de solicitante de mano de obra'
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
		echo("<label>". $row["nombresubmenu"]."-</label><br>");
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

      <h2><legend>Contrato de mano de obra</legend></h2>
        <img src="../images/cargoManoobra.jpg" width="60" height="60" /><br>
       <table id="tableSolicitud" width="900" align="left">
      <thead>
            	<tr>
                    <th width="20"><label>Nro</label></th>
                    <th width="100"><label>Cargo</label></th>
                    <th width="130"><label>Responsable</label></th>
                    <th width="20"><label>Cantidad solicitada</label></th>
                    <th width="20"><label>Cantidad incorporada</label></th>
                    <th width="60"><label>Estado</label></th>
                    <th width="120"><label>Fecha de solicitud</label></th>
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
			color:#093;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
				}
				#button:hover{
				background:#ddd;
			}
			pendiente{
				color:#F00;
				}
			atendido{
				color:#093;
				}
			.enlace{
				text-decoration:none;
				}
			.enlace:hover{
				color:#069;
				}
			</style>      
<?php
	$sql=$dbh->prepare("SELECT IDsolicitud, nro, c.nombre, e.nombres, app, apm, cantidad_solicitada, cantidad_contratada,s.estado,fechaSolicitud,  hraSolicitud, p.IDproyecto
                        FROM solicita AS s, empleado AS e, personaltecnico AS pt, cargomanodeobra AS c, proyecto AS p
                        WHERE c.IDcargoM = s.IDcargo_M
                        AND s.IDpersonalTecnico = pt.IDpersonalTecnico
                        AND s.IDproyecto = p.IDproyecto
                        AND pt.CI = e.CI");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$idsol=$row[0];
		$estado=$row[8];
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td align="center"><?php echo $row[3]." ".$row[4]." ".$row[5];?></td>
     <td align="center"><?php echo $row[6];?></td>
     <td align="center"><?php echo $row[7];?></td>
     <td align="center"><?php if($estado=="Pendiente")
	                          echo "<pendiente>".$row[8]."</pendiente>";
							  else
							  echo "<atendido>".$row[8]."</atendido>";?></td>
     <td align="center"><?php echo $row[9]." ".$row[10];?></td>
     <td align="center"><a href="<?php echo"registros/addTrabajadorProyecto.php?idsol=$idsol&nombCargo=$row[2]&fec=$row[9]&hra=$row[10]&idproy=$row[11]&cant=$row[6]";?>" class="enlace">Añadir trabajadores</a></td></tr>
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
