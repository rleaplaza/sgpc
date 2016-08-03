<?php
session_start();
?>
<html>
<head><title>Asignacion de personal a proyectos</title>

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/tabber.js"></script>

    <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablePersonalTecnico").dataTable({
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
			var idemp = param;
			ajaxFace = new LightFace.Request({
				url: 'setPersonalTecnico.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codEmp: idemp || 'Id de empleado no ingresado',
						IDproyecto:document.id('idproy').value || 'Id de usuario no ingresado',
						IDplan:document.id('idplan').value || 'Nro no almacenado'
					},
					method: 'post'
				},
				title: 'Asignacion de personal Técnico a proyecto'
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
			var idemp = param;
			ajaxFace = new LightFace.Request({
				url: 'deletePersonalTecnico.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codEmp: idemp || 'Id de empleado no ingresado',
						IDproyecto:document.id('idproy').value || 'Id de proyecto no ingresado'
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
if(isset($_SESSION["username"])){
	 try{
		 include("../../db/connect.php");
		 $idproy=$_GET["idproy"];
		 $sql1=$dbh->prepare("select IDplanificacion, descripcion from planificacion 
		                      where fecFin is Null and IDproyecto=?");
         $sql1->bindParam(1,$idproy);
         $sql1->execute();
         $result=$sql1->fetch();
         $idplan=$result[0];
		 $sql=$dbh->prepare("select *from proyecto where IDproyecto=?");
		 $sql->bindParam(1,$idproy);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
	        echo("<table><tr><td><label>Nombre de proyecto: </label></td><td><label>".$row["nombre"]. "</label></td></tr>
						</table>");
		 }

	 echo("<input type=submit value='Volver a listado de proyectos' onClick='history.back();' id=button>");
		 ?>
      
          <fieldset id="content">
           <legend>Listado de Personal de recursos humanos para obras civiles</legend>
           <img src="../../images/personalproyectos.jpg" height="40" width="40">
          <table  id="tablePersonalTecnico" align="left">
                        <thead>
                        <tr>
                        <th><label>Cédula de empleado</label></th>
                        <th><label>Nombre completo de empleado</label></th>
                        <th ><label>Cargo</label></th>
                        <th><label>Departamento</label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
         <?php
 $sql2=$dbh->prepare("SELECT e.IDempleado, CI, e.nombres, app, apm, c.nombre, d.nombre
                      FROM empleado AS e, cargo AS c, departamento AS d
                      WHERE e.IDcargo = c.IDcargo
                      AND e.IDdepto = d.IDdepto
                      AND d.nombre in('Proyectos','Superintendencia de obras')");
				$sql2->execute();
				if($sql2->rowCount()>0){
					$fila=$sql2->rowCount();
					foreach($sql2->fetchAll() as $fila){
						$idempleado=$fila[0];
						?>
                       <tr> 
                        <td><?php echo($fila[1]);?></td>
                        <td><?php echo($fila[2])." ".$fila[3]." ".$fila[4];?></td>
                        <td><?php echo($fila[5]);?></td>
                        <td><?php echo($fila[6]);?></td>
<td>
<input type="hidden" id="idproy" value="<?php echo $idproy;?>">
<input type="hidden" id="idplan" value="<?php echo $idplan;?>">
<input type="button" tipoPerm="<?php echo $idempleado;?>" onclick="fun('<?php echo $idempleado;?>'); return false;" class="submit classPermisos" value="Asignar Como Personal Técnico" id="button"></td>

<td><input type="hidden" id="idproy" value="<?php echo $idproy;?>"><input type="button" tipoPerm="<?php echo $idempleado;?>" id="button1" onclick="fun1('<?php echo $idempleado;?>'); return false;" class="submit classPermisos" value="Eliminar De Personal Técnico"></td>

                      </tr>
                        <?php
						}
						?>
                        </table>
                        </fieldset>
  <?php
    				
	}
	 }catch(PDOException $e){
		 echo("Error inesperado".$e->geMessage());
		 }
}
else{
	header("location: ../../index.php");
	}
	  ?>
      </body>
</html>