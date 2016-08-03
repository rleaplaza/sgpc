<?php
session_start();
?>
<html>
<head><title>Asignacion de trabajadores a proyecto</title>

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/tabber.js"></script>

    <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableAsignacion").dataTable({
				"sScrollY":"200px",
				"bpaginate":true
				});
        });
   </script>
   
<script type="text/javascript" src="lightface/Source/mootools.js"></script>
<script type="text/javascript" src="lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="lightface/Source/LightFace.Request.js"></script>

<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var nroitem = param;
			ajaxFace = new LightFace.Request({
				url: 'setMaqProyecto.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDmaq: document.id('idmaquinaria').value || 'Id de opcion no ingresado',
						IDproy:document.id('idproyecto').value || 'Ningún id de proyecto',
						Cantidad:document.id('cantidad').value ||  'cantidad no agregada',
						IDsolicitud:document.id('idsolicitud').value || 'ID de solicitud no ingresado',
						NroItem:nroitem
					},
					method: 'post'
				},
				title: 'Asignacion de trabajadores a proyecto'
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
			var idtrabajador = param;
			ajaxFace = new LightFace.Request({
				url: '../delete/deleteTrabajador.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codTrabajador: idtrabajador || 'Id de opcion no ingresado',
						IDproy:document.id('idproyecto').value || 'Ningún id de proyecto'
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
<img src="../../images/maquinaria1.jpg" height="30" width="30">


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
				#button:hover{
					background:#ddd;
					}
				#button1:hover{
					background:#ddd;
					}
			</style>
            </head>
            <body>
           
           
<?php
if(isset($_SESSION["username"])){
	 try{
		 include("../../db/connect.php");
		 $idsolicitud=$_GET["idsol"];
		 $desc=$_GET["desc"];
		 $idproy=$_GET["idproy"];
		 $cant_sol=$_GET["cant"];
		 $fec=$_GET["fec"];
		 $sql=$dbh->prepare("select *from maquinaria where descripcion=?");
		 $sql->bindParam(1,$desc);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
		    $descripcion=$row["descripcion"];
	        echo("<table><tr><td><label>Descripcion: </label></td><td><label>".$descripcion. "</label></td></tr>
			<tr><td><label>Fecha de solicitud: </label></td><td><label>".$fec. "</label></td></tr>
						 </table>");
		 ?>
         <input type="submit" value='Volver a listado anterior' onClick='history.back();' id="button">
          <fieldset id="content">
           <legend>Listado de items por maquinaria</legend>
          <table  id="tableAsignacion" align="left">
                        <thead>
                        <tr>
                        <th width="10"><label>Nro</label></th>
                        <th><label>Descripción</label></th>
                        <th><label>Cargo</label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
         <?php
  $sql1=$dbh->prepare("SELECT nro, item_maquinaria.descripcion, maquinaria.IDmaquinaria
                       FROM item_maquinaria, maquinaria
                       WHERE item_maquinaria.IDmaquinaria = maquinaria.IDmaquinaria
                       AND maquinaria.descripcion = 'cargador frontal PQ <= 100HP'
                       AND estado = 'Pendiente de solicitud'");
								 
			$sql1->bindParam(1,$desc);
			$sql1->execute();
				if($sql1->rowCount()>0){
					foreach($sql1->fetchAll() as $equipo){
						$nroitem=$equipo[0];
						$idmaquinaria=$equipo[2];
						?>
                       <tr> 
                        <td><?php echo($equipo[0]);?></td>
                        <td><?php echo($equipo[1]);?></td>
<td><input type="hidden" value="<?php echo $nroitem;?>" id="nroitem">
    <input type="hidden" value="<?php echo $idproy;?>" id="idproyecto">
    <input type="hidden" value="<?php echo $cant_sol;?>" id="cantidad">
    <input type="hidden" value="<?php echo $idsolicitud;?>" id="idsolicitud">
    <input type="hidden" value="<?php echo $idmaquinaria;?>" id="idmaquinaria">
    <input type="button" tipoPerm="<?php echo $nroitem;?>" onclick="fun('<?php echo $nroitem;?>'); return false;" class="submit classPermisos" value="Asignar a proyecto" id="button"></td>

<td><input type="hidden" value="<?php echo($nroitem)?>" id="idtrabajador">
    <input type="hidden" id="idproyecto" value="<?php echo($idproy)?>">
    <input type="button" tipoPerm="<?php echo $nroitem;?>" id="button1" onclick="fun1('<?php echo $nroitem;?>'); return false;" class="submit classPermisos" value="Eliminar de proyecto"></td>

                      </tr>
                        <?php
						}
						?>
                        </table>
                        </fieldset>
                        <?php
					}else{
						echo "<label>No se encontraron resultados</label>";
						}
		
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