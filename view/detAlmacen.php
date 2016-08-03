<?php 
session_start();//función de inicio de sesión
#Este programa se encarga de mostrar el detalle de pedido a almacenes
?>
<html>
<head><title>Registro de items solicitados</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//captura el id de la tabla
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//archivo de traducción
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
	window.addEvent('domready',function(){//inicia el evento
			
			document.id('button1').addEvent('click',function(){//captura el id del botón del formulario
				
				ajaxFace = new LightFace.Request({
					url: 'registros/updatePedidoAlmacen.php',//url destino
					buttons: [//botón de cerrado
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura el nro del pedido
						    Nro:document.id('nro').value || 'nombre no agregado',
						},
						method: 'post'//método post
					},
					title: 'Actualización de pedido'//título de la ventana
				}).open();
				//abre la ventana
			});
			
		});    
</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
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
				color:#00F;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
			#button1:hover{
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
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//archivo log de auditoría
	$nro=$_GET["nro"];
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
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
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
?>
      <h2><legend>DETELLE DE PEDIDO EN ALMACÉN</legend></h2>
        <img src="../images/almacen.jpg" width="30" height="30" /><br>
        <input type="submit" value="VOLVER" id="button" onClick="history.back();">
        <input type="hidden" value="<?php echo $nro;?>" id="nro">
        <input type="button" id="button1" class="boton_envio" value="PROCESAR SOLICITUD">
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Descripción</label></th>
                    <th><label>Cantidad</label></th>
                    <th><label>Unidad</label></th>
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
#captura la descripción de item, cantidad solicitada y unidad para el detalle del pedido
	$sql=$dbh->prepare("select descripcion_item, cantidad_sol, unidad from det_pedido_almacen
	                    where Nro_pedido=?");
	$sql->bindParam(1,$nro);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td width="400"><?php echo $row[0]//campo descripción de item;?></td>
     <td align="center"><?php echo $row[1]//cantidad solicitada;?></td>
     <td align="center"><?php echo $row[2]//campo unidad;?></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");//dirige al login
	}
?>
</body>
</html>