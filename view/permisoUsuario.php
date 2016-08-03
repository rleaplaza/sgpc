<html>
<?php
session_start();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestión de permisos</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script>
		window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/saveEstado.php',
					buttons: [
						//{ title: 'Submitter', event: function() { alert('hi!'); }, color: 'blue' },
						{ title: 'Cerrar', event: function() { this.close(); } ,color:'blue'}
					],
					request: { 
						data: { 
							userId: document.id('iduser').value,
							status:document.id('estado').value
						},
						method: 'post'
					},
					title: 'Estado de usuario'
				}).open();
				
			});
			
		});
	</script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermiso").dataTable({
				"sScrollY":"200px",
				"bPaginate":true,
				"oLanguage":{//archivo de traducción al castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
				});
		</script>
        <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
					#sub{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#06C;
				border-radius:8px 8px 8px 8px;
				color:#FFF;
				}
				#sub:hover{
					background:#999;
					}
					#sub1{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#06C;
				border-radius:8px 8px 8px 8px;
				color:#FFF;
				}
				#sub1:hover{
					background:#999;
					}
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

<img src="../images/permisos.jpg" width="50" height="50" /><br>
<?php
if(isset($_SESSION["username"])){ 
try{ 
include("../db/connect.php");
$iduser=$_GET["id"];
$query=$dbh->prepare("select *from usuario where USR_UID=?");
$query->bindParam(1,$iduser);
$query->execute();
$row=$query->fetch();
?>
<label>Permisos del usuario: </label><?php echo"<b>".$row["username"]."</b>";?><br>
<input type="submit" value="Volver a user list" onClick='history.back();' id="sub1"><br>
<label>Seleccionar Estado</label>

<input type="hidden" value="<?php echo $row["USR_UID"]?>" name="iduser" id="iduser">
<select name="estado" id="estado">
<option value="activo">Activo
<option value="inactivo">Inactivo
<option value="vacacion">Vacacion
</select>
<input type="button" value="Cambiar estado" id="sub" class="submit">
</form><br>
<fieldset id="content">
<legend>Listado de permisos asignados</legend>
       <table id="tablepermiso" width="800" align="left">
      <thead>
            	<tr>
                    <th width="188"><label>Codigo de opcion</label></th>
                    <th width="185"><label>Nombre de opcion del permiso</label></th>
                    <th width="185"><label>Estado del permiso</label></th>
                    <th width="185"><label>Fecha de asignación</label></th>
                    <th width="185"><label>Hora de asignación</label></th>
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
			 activo{
				 color:#093;
				 }
			 inactivo{
				 color:#F00;
				 }
			</style>
<?php

$sql=$dbh->prepare("select *from usuario where USR_UID=?");
$sql->bindParam(1,$iduser);
$sql->execute();
$row=$sql->fetch();
$sql=$dbh->prepare("SELECT opcion.IDopcion, nombreopcion, permiso.estado, fecha_asignacion, hraAsignacion
                    FROM opcion, permiso, usuario
                    WHERE opcion.IDopcion = permiso.IDopcion
                    AND permiso.USR_UID = usuario.USR_UID
                    and username=? and permiso.estado='activo'");
		$sql->bindParam(1,$row["username"]);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchall() as $row){
				?>
                <tr>
     <td><?php echo $row[0];?></td>
     <td><?php echo $row[1];?></td>
     <td align="center"><?php if($row[2]=="activo")
	           echo "<activo>".$row[2]."</activo>";
	           else if($row[2]=="inactivo")
			   echo "<inactivo>".$row[2]."</inactivo>";?></td>
     <td align="center"><?php echo $row[3];?></td>
     <td align="center"><?php echo $row[4];?></td> 
     </tr>
                <?php
				}
				?>
                </table>
               </fieldset>
                <?php
			}	
	}catch(PDOException $e){
	echo("Error".$e->getMessage());
	}
}
else{
	header("location: ../index.php");
	}
 ?>
</body>
</html>