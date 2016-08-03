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
        <script type="text/javascript" src="../js/ajaxgr.js"></script>

    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idferiado = param;
			ajaxFace = new LightFace.Request({
				url: 'delete/deleteFeriado.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDferiado: idferiado || 'Id de feriado no capturado',
					},
					method: 'post'
				},
				title: 'Eliminar feriado'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			#sub{ font-wight:bold;
			   cursor:pointer;
			   padd ing:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-razdius:8px 8px 8px 8px;
		      }
		 #sub:hover{
				background:#ddd;
			}
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/reveal.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.idealforms.min.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
if(isset($_POST["consulta"])){
	
?>
      <h2><legend>CONTROL DE FERIADOS</legend></h2>
      <img src="../images/calendario.jpg" width="30" height="30" /><br>
      <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="26" width="26" title="Para consultar feriados escriba una palabra correspondiente a cada registro existente dentro del campo buscar"><br>
      <input type="submit" value="Volver al formulario" onclick='history.back();' id="sub">
        
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Nombre</label></th>
                    <th><label>Descripcion</label></th>
                    <th><label>Fecha de inicio</label></th>
                    <th><label>Fecha de finalizacion</label></th>
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
			background:#F00;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#666;
					}
					 #button1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00C;
			border-radius:8px 8px 8px 8px;
			}
				#button1:hover{
					background:#666;
					}
			</style>
<?php

	$sql=$dbh->prepare("select *from calendario_feriado");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td align="center"><button id="button1" onclick="editFeriado('<?php echo $row[0];?>')">Editar Feriado</button></td>
     <td align="center">
     <input type="hidden" value="<?php echo($row[0])?>" id="idferiado"><input type="button" onclick="fun('<?php echo $row[0];?>'); return false;" class="submit classPermisos" value="Eliminar Feriado" id="button"></td></tr>
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