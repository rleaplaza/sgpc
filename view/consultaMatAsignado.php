<?php 
session_start();//función de inicio de sesión
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
        $(document).ready( function() {//función de la tabla
            $("#tableParam").dataTable({//captura el id de la table
				"sScrollY":"250px",//scroll vertival
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
<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idparam = param;
			ajaxFace = new LightFace.Request({//instancia a la clase lightfase
				url: 'delete/deleteParam.php',//url destino
				buttons: [//establece el botón para cerrar la ventana
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { //captura el id del parametro
						IDparam: idparam || 'Id de parámetro no ingresado',
					},
					method: 'post'
				},
				title: 'Eliminar parámetro'
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
	$idactividad=$_GET["idactividad"];
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
      <h2><legend>MATERIALES ASIGNADOS A LA ACTIVIDAD </legend></h2><?php echo $_GET["nombreActividad"];?><br>
        <img src="../images/materiales.jpg" width="30" height="30" />
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Material</label></th>
                    <th><label>Cantidad programada</label></th>
                    <th><label>Cantidad entregada</label></th>
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
			color:#F00;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
			</style>
<?php

	$sql=$dbh->prepare("SELECT descripcion, cantidad_programada, cant_solicitada, actividad_material.unidad
	                    from material, actividad_material, actividad
                        WHERE material.IDmaterial = actividad_material.IDmaterial
                        AND actividad_material.IDactividad = actividad.IDactividad
						and actividad.IDactividad=?");
	$sql->bindParam(1,$idactividad);
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td align="center"><?php echo $row[1]." ".$row[3];?></td>
     <td align="center"><?php echo $row[2]." ".$row[3];?></td>
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