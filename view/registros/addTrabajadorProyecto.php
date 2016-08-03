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
			var idtrabajador = param;
			ajaxFace = new LightFace.Request({
				url: 'setTrabajadorProyecto.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codTrabajador: idtrabajador || 'Id de opcion no ingresado',
						IDproy:document.id('idproyecto').value || 'Ningún id de proyecto',
						Cantidad:document.id('cantidad').value ||  'cantidad no agregada',
						IDsolicitud:document.id('idsolicitud').value || 'ID de solicitud no ingresado',
						IDplan:document.id('idplan').value || 'ID de planificación no almacenado'
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
		var fun1 = function (param,param2) {
			//var idPerm = $(this).attr("tipoPerm");
			var idtrabajador = param;
			var idcargo=param2;
			ajaxFace = new LightFace.Request({
				url: '../delete/deleteTrabajador.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codTrabajador: idtrabajador || 'Id de opcion no ingresado',
						IDproy:document.id('idproyecto').value || 'Ningún id de proyecto',
						IDcargo:idcargo || 'Cargo no encontrado'
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
		 #captura de variables
		 $idsolicitud=$_GET["idsol"];
		 $nombCargo=$_GET["nombCargo"];
		 $fec=$_GET["fec"];
		 $hra=$_GET["hra"];
		 $idproy=$_GET["idproy"];
		 $cant_sol=$_GET["cant"];
		 #consulta de la planificación del proyecto para identificar por ID
		 $consulta=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is Null");
		 $consulta->bindParam(1,$idproy);
		 $consulta->execute();
		 $result=$consulta->fetch();
		 $idplan=$result[0];
		 #consulta del cargo de mano de obra
		 $sql=$dbh->prepare("select *from cargomanodeobra where nombre=?");
		 $sql->bindParam(1,$nombCargo);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
			#Datos de la solicitud del cargo, fecha y hora
		    $nombrecargo=$row["nombre"];
	        echo("<table><tr><td><label>Nombre del cargo: </label></td><td><label>".$nombrecargo. "</label></td></tr>
			<tr><td><label>Fecha de solicitud: </label></td><td><label>".$fec. "</label></td></tr>
			<tr><td><label>Hora de solicitud: </label></td><td><label>".$hra. "</label></td></tr>
						 </table>");
		 ?>
         <input type="submit" value='Volver a listado anterior' onClick='history.back();' id="button">
          <fieldset id="content">
           <legend>Listado de Trabajadores por cargo</legend>
          <table  id="tableAsignacion" align="left">
                        <thead>
                        <tr>
                        <th><label>Cédula</label></th>
                        <th><label>Nombre completo</label></th>
                        <th><label>Cargo</label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
         <?php
  $sql1=$dbh->prepare("SELECT CI_trabajador, pm.nombre, ap_p, ap_m, c.nombre,c.IDcargoM
                                 FROM personalmanoobra AS pm, cargomanodeobra AS c
                                 WHERE pm.IDcargoM = c.IDcargoM
								 and c.nombre=?");
			$sql1->bindParam(1,$nombCargo);
			$sql1->execute();
				if($sql1->rowCount()>0){
					foreach($sql1->fetchAll() as $trabajador){
						$idtrabajador=$trabajador[0];
						?>
                       <tr> 
                        <td><?php echo($trabajador[0]);?></td>
                        <td><?php echo($trabajador[1]." ".$trabajador[2] ." ".$trabajador[3]);?></td>
                        <td><?php echo($trabajador[4]);?></td>
<td><input type="hidden" value="<?php echo $idtrabajador;?>" id="idtrabajador">
    <input type="hidden" value="<?php echo $idproy;?>" id="idproyecto">
    <input type="hidden" value="<?php echo $cant_sol;?>" id="cantidad">
    <input type="hidden" value="<?php echo $idsolicitud;?>" id="idsolicitud">
    <input type="hidden" value="<?php echo $idplan;?>" id="idplan">
    <input type="button" tipoPerm="<?php echo $idtrabajador;?>" onclick="fun('<?php echo $idtrabajador;?>'); return false;" class="submit classPermisos" value="Asignar a proyecto" id="button"></td>

<td><input type="hidden" value="<?php echo($idtrabajador)?>" id="idtrabajador">
    <input type="hidden" id="idproyecto" value="<?php echo($idproy)?>">
    <input type="button" tipoPerm="<?php echo $idtrabajador;?>" id="button1" onclick="fun1('<?php echo $idtrabajador;?>','<?php echo $trabajador[5];//id de cargo;?>'); return false;" class="submit classPermisos" value="Eliminar de proyecto"></td>

                      </tr>
                        <?php
						}
						?>
                        </table>
                        </fieldset>
                        <?php
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