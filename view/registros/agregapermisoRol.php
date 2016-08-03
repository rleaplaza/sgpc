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
				url: 'setpermisosRol.php',//registro de permisos a roles
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { //captura el id de opcion e id de rol
						codOpcion: idPerm || 'Id de opcion no ingresado',
						IDrol:document.id('idrol').value || 'Id de usuario no ingresado'
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
			var idPerm = param;
			ajaxFace = new LightFace.Request({
				url: 'desactivarPermisoRol.php',//url para eliminar permiso
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: {  //captura el id de opcion e id de rol
						codOpcion: idPerm || 'Id de opcion no ingresado',
						IDrol:document.id('idrol').value || 'Id de usuario no ingresado'
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
<img src="../../images/permisos.jpg" height="30" width="30">


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
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
	#button:hover{
				background:#ddd;
					}
	#button1{font-wight:bold;
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
            </head>
            <body>
           
           
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	 try{
		 require_once("../../db/connect.php");//llama a la conexion a base de datos
		 $idrol=$_GET["idrol"];//captura el id de rol
		 $idmenu=$_GET["idmenu"];//captura el id del menu
		 #consulta del rol
		 $sql=$dbh->prepare("select *from rol where IDrol=?");
		 $sql->bindParam(1,$idrol);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
		    $nombrerol=$row["nombreRol"];//captura el nombre de rol
	        echo("<table><tr><td><label>ID de rol: </label></td><td><label>".$idrol. "</label></td></tr>
						 </table>");
						 #consulta de las opciones en base al rol 
			
		 }
		 $consulta=$dbh->prepare("select *from menu where IDmenu=?");
		 $consulta->bindParam(1,$idmenu);
		 $consulta->execute();
		 if($consulta->rowCount()>0){
			 $row=$consulta->fetch();
	 echo "<label>Opciones del Menú ".$row["nombreMenu"]."</label><br>";
	 ?>
     <a href="<?php echo "../../reportes/administracion/permisoRol.php?idrol=$idrol"?>"><img src="../../images/pdf.jpg" height="20" width="20"></a><br>
     <?php
	 echo("<input type=submit value='Volver a listado de usuarios' onClick='history.back();' id=button>");
		 }
		 ?>
          <fieldset id="content">
           <legend>Listado de Permisos de acceso</legend>
          <table  id="tablepermission" align="left">
                        <thead>
                        <tr>
                        <th><label>Nombre de Submenu</label></th>
                        <th ><label>Codigo de Opción</label></th>
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
                        <td><?php echo($opcion[0]);//nombre de submenu?></td>
                        <td><?php echo($opcion[1]);//id de opcion?></td>
                        <td><?php echo($opcion[2]);//nombre de opcion?></td>
                        <td><?php echo($opcion[3]);//estado de permiso?></td>
<td><input type="hidden" value="<?php echo($idopcion)?>" id="idopcion">
    <input type="hidden" id="idrol" value="<?php echo($idrol)?>">
    <input type="button" tipoPerm="<?php echo $idopcion;?>" onclick="fun('<?php echo $idopcion;?>'); return false;" class="submit classPermisos" value="Asignar Permiso" id="button"></td>

<td><input type="hidden" value="<?php echo($idopcion)?>" id="idopcion">
    <input type="hidden" id="idrol" value="<?php echo($idrol)?>">
    <input type="button1" tipoPerm="<?php echo $idopcion;?>" id="button1" onclick="fun1('<?php echo $idopcion;?>'); return false;" class="submit classPermisos" value="Eliminar Permiso"></td>

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
	header("location: ../../index.php");//redirige al login
	}
	  ?>
      </body>
</html>