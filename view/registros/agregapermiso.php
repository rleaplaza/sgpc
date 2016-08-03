<?php
session_start();
?>
<html>
<head><title>Asignacion de permisos</title>

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/tabber.js"></script>

    <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermission").dataTable({
				"sScrollY":"200px",
				"bpaginate":true
				});
        });
   </script>
   
<script type="text/javascript" src="lightface/Source/mootools.js"></script>
<script type="text/javascript" src="lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="lightface/Source/LightFace.Request.js"></script>

<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idPerm = param;
			ajaxFace = new LightFace.Request({
				url: 'setpermisos.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codOpcion: idPerm || 'Id de opcion no ingresado',
						IDusuario:document.id('iduser').value || 'Id de usuario no ingresado'
					},
					method: 'post'
				},
				title: 'Asignacion de permisos'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
    <script type"text/javascript">
//Desactivar permiso
		var fun1 = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idPerm = param;
			ajaxFace = new LightFace.Request({
				url: 'desactivarPermiso.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codOpcion: idPerm || 'Id de opcion no ingresado',
						IDusuario:document.id('iduser').value || 'Id de usuario no ingresado'
					},
					method: 'post'
				},
				title: 'Eliminación de Permiso'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
    
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<img src="../../images/permisos.jpg" height="30" width="30"><br>


<style>
       label{ font:Verdana, Geneva, sans-serif;
		     color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
			   background:#CCC;
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
				background:#666;
					}
	#button1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#F00;
			border-radius:8px 8px 8px 8px;
			}
				#button1:hover{
					background:#666;
					}
			</style>
            </head>
            <body>
           
           
<?php
if(isset($_SESSION["username"])){
	 try{
		 include("../../db/connect.php");
		 $iduser=$_GET["idusuario"];
		 $idmenu=$_GET["idmenu"];
		 $sql=$dbh->prepare("select *from usuario where USR_UID=?");
		 $sql->bindParam(1,$iduser);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
		    $username=$row[1];
	        echo("<table><tr><td><label>USER ID: </label></td><td><label>".$iduser. "</label></td></tr>
			             <tr><td><label>Usuario: </label></td><td><label>".$username."</label></td></td>
						</table>");
	        $sql1=$dbh->prepare("SELECT nombreOpcion, usuario.USR_UID
                                FROM permiso, opcion, usuario
                                WHERE usuario.USR_UID = permiso.USR_UID
                                AND permiso.IDopcion = opcion.IDopcion
								and usuario.USR_UID=?");
			$sql1->bindParam(1,$iduser);
			$sql1->execute();
			if($sql1->rowCount()>0){
				?>
               <a href="<?php echo "../../reportes/administracion/permisoUsuario.php?user=$username";?>"><img src="../../images/pdf.jpg" height="20" width="20" title="Consultar permisos asignados"></a> 
		    <table align="left">
            <?php
			 foreach($sql1->fetchAll() as $fila){
				 ?>
                 <td border="2"><?php echo "<label>" //strtolower($fila["nombreOpcion"])."-</label>";?></td>
                 <?php
				 }
				 ?>
                 </table>
                 <br>
               <?php
			}
			else{
				echo("<label>El usuario no tiene permisos asignados</label><br>");
				}
	
		 }
		 $consulta=$dbh->prepare("select *from menu where IDmenu=?");
		 $consulta->bindParam(1,$idmenu);
		 $consulta->execute();
		 if($consulta->rowCount()>0){
			 $row=$consulta->fetch();
	 echo "<label>Opciones del Menú ".$row["nombreMenu"]."</label><br>";
	 echo("<input type=submit value='Volver a listado de usuarios' onClick='history.back();' id=button>");
		 }
		 ?>
          <fieldset id="content">
           <legend>Listado de Permisos de acceso</legend>
          <table  id="tablepermission" align="left">
                        <thead>
                        <tr>
                        <th><label>Nombre de Submenu</label></th>
                        <th><label>Codigo de Opción</label></th>
                        <th><label>Nombre de Opción</label></th>
                        <th><label>Estado de Opción</label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
         <?php
 $sql2=$dbh->prepare("SELECT nombreSubmenu, opcion.IDopcion, opcion.nombreOpcion, estado
                      FROM menu, submenu, opcion
                      WHERE menu.IDmenu = submenu.IDmenu
                      AND submenu.IDsubmenu = opcion.IDsubmenu
                      AND menu.IDmenu =? 
					  AND estado='activo' order by opcion.IDopcion");
					  $sql2->bindParam(1,$idmenu);
				$sql2->execute();
				if($sql2->rowCount()>0){
					$fila=$sql2->rowCount();
					foreach($sql2->fetchAll() as $opcion){
						$idopcion=$opcion[1];
						?>
                       <tr> 
                        <td><?php echo($opcion[0]);?></td>
                        <td><?php echo($opcion[1]);?></td>
                        <td><?php echo($opcion[2]);?></td>
                        <td><?php echo($opcion[3]);?></td>
<td><input type="hidden" value="<?php echo($idopcion)?>" id="idopcion"><input type="hidden" id="iduser" value="<?php echo($iduser)?>"><input type="button" tipoPerm="<?php echo $idopcion;?>" onclick="fun('<?php echo $idopcion;?>'); return false;" class="submit classPermisos" value="Asignar Permiso" id="button"></td>

<td><input type="hidden" value="<?php echo($idopcion)?>" id="idopcion"><input type="hidden" id="iduser" value="<?php echo($iduser)?>"><input type="button" tipoPerm="<?php echo $idopcion;?>" id="button1" onclick="fun1('<?php echo $idopcion;?>'); return false;" class="submit classPermisos" value="Eliminar Permiso"></td>

                      </tr>
                        <?php
						}
						?>
                        </table>
                        </fieldset>
                        <?php
					}
		
	 }
	 catch(PDOException $e){
		 echo("Error inesperado".$e->geMessage());
		 }
}
else{
	header("location: ../../index.php");
	}
	  ?>
      </body>
</html>