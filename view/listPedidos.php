<?php 
session_start();//función de inicio de sesión
?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//enlaza al id de la tabla
				"sScrollY":"250px",//habilita el scroll vertival
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//traducción al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
<script type="text/javascript" language="Javascript">
var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var nroPedido=param
			ajaxFace = new LightFace.Request({
				url: 'registros/cancelarPedido.php',
				buttons: [
					{ title: 'Cerrar', event: function() { 
					                          this.close();
											  recargar(); },color:'blue' }
				],
				request: { 
					data: { 
						NroPedido: nroPedido || 'Id no almacenado'
					},
					method: 'post'
				},
				title: 'Cancelación de pedido'
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
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/cssEstado.css" rel="stylesheet" type="text/css">
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
		$idopcion=$_GET["idopcion"];
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
      <h2><legend>Registro de pedidos</legend></h2>
        <img src="../images/pedido.jpg" width="30" height="30" />
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha</label></th>
                    <th><label>Número de pedido</label></th>
                    <th><label>Proveedor</label></th>
                    <th><label>Total pedido</label></th>
                    <th><label>Estado</label></th>
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
			  #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#F00;
			border-radius:5px 5px 5px 5px;
				}
			#button:hover{
			background:#666;
			cursor:pointer;
			}
			</style>
<?php

	$sql=$dbh->prepare("SELECT pedido_material.fecRegistro, nro_pedido, empProveedora, total,estado, proveedor.IDproveedor
                        FROM pedido_material, proveedor
                        WHERE pedido_material.IDproveedor = proveedor.IDproveedor
						");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row[0];?></td>
     <td align="center"><?php echo $row[1];?></td>
     <td align="center"><?php echo $row[2];?></td>
     <td align="center"><?php if($row[3]!=null)
	                             echo $row[3]." Bs";
							else
							   echo "Sin monto"?></td>
     <td align="center"><?php if($row[4]=="Pendiente")
	                          echo "<yellow>".$row[4]."</yellow>";
							  else if($row[4]=="Cancelado")
							  echo "<red>".$row[4]."</red>";
							  else if($row[4]=="Atendido")
							  echo "<green>".$row[4]."</green>";?></td>
      <td align="center">
      <input type="button" onclick="fun('<?php echo $row[1];?>'); return false;" class="submit classPermisos" value="Cancelar pedido" id="button"></td>
  </tr>
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