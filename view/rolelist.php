<?php  session_start(); //función de inicio de sesión?>
<html>
<head><title>Registro de roles</title>

<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableRol").dataTable({
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
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idRol = param;
			ajaxFace = new LightFace.Request({
				url: 'userRol.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codRol: idRol || 'Id de rol no ingresado',
					},
					method: 'post'
				},
				title: 'Usuarios activos'
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
<link href="../css/enlaces.css" rel="stylesheet" type="text/css">
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
		require_once("consultas/mensajeAyuda.php");
		$mensaje=consultaMensaje($_GET["idopcion"]);
		?>
        <img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
?>
<label>Ayuda del sistema</label> 
      <img src="../images/rol de usuario.gif" width="30" height="30" />
      <h2><legend>ROLES DEL SISTEMA</legend></h2>
        
       <table id="tableRol" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Codigo</label></th>
                    <th><label>Nombre</label></th>
                    <th><label>Descripción</label></th>
                    <th><label>Fecha de creación</label></th>
                    <th><label>Hora de creación</label></th>
                    <th><label></label></th>
                    <th><label></label></th>
                    <th><label></label></th>
                    <th><label></label></th>
                    <th><label></label></th>
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
		    #submit{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#F00;
			border-radius:8px 8px 8px 8px;
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
				background:#666;
				}
			#submit:hover{
				background:#666;
					}
			</style>
<?php

	$sql=$dbh->prepare("select *from rol");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td><?php echo $row[1];?></td>
     <td><?php echo $row[2];?></td>
     <td><?php echo $row[3];?></td>
     <td><?php echo $row[4];?></td>
     <td><a href="<?php echo("registros/menu2.php?idrol=$row[0]")?>" class="enlace">Asignar Permisos</a></td>
     <td><a href="<?php echo("edit/editRol.php?id=$row[0]");?>" class="enlace">Editar Rol</a></td>
     <td><a href="<?php echo("permisoRol.php?idrol=$row[0]");?>" class="enlace">Ver Permisos</a></td>
     <td><input type="hidden" value="<?php echo($row[0])?>" id="idRol"><input type="button" onclick="fun('<?php echo $row[0];?>'); return false;" class="submit classPermisos" value="Usuarios activos" id="button"></td>
     <td width="100"><form action="delete/deleteRol.php" method="post">
     <input type="hidden" name="idRol" value="<?php echo $row[0];?>">
     <input type="submit" id="submit" value="Eliminar Rol"></form></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
}
else{ 
header("location: ../index.php");
	}
?>
</body>
</html>

