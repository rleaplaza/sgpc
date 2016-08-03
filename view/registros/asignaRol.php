<?php
session_start();
?>
<html>
<head><title>Asignacion de rol</title>

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/tabber.js"></script>

    <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermission").dataTable({
				"sScrollY":"200px",
				"bPaginate":true
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
			var idRol = param;
			ajaxFace = new LightFace.Request({
				url: 'setRol.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codRol: idRol|| 'Id de opcion no ingresado',
						IDusuario:document.id('iduser').value || 'Id de usuario no ingresado'
					},
					method: 'post'
				},
				title: 'Asignacion de roles'
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
			var idRol = param;
			ajaxFace = new LightFace.Request({
				url: 'deleteRol.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codRol: idRol || 'Id de opcion no ingresado',
						IDusuario:document.id('iduser').value || 'Id de usuario no ingresado'
					},
					method: 'post'
				},
				title: 'Eliminar rol'
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
		 $iduser=$_GET["idusuario"];
		 $sql=$dbh->prepare("select *from usuario where USR_UID=?");
		 $sql->bindParam(1,$iduser);
		 $sql->execute();
		 if($sql->rowCount()>0){
			$row=$sql->fetch();
		    $username=$row[8];
	        echo("<table><tr><td><label>USER ID: </label></td><td><label>".$iduser. "</label></td></tr>
			             <tr><td><label>Nombre de usuario:</label></td><td><label>".$row[1]."</label></td></tr>
						 </table>");
	        $sql1=$dbh->prepare("select rol.IDrol, nombreRol from usuario, rol
						         WHERE usuario.IDrol=rol.IDrol
						         and usuario.USR_UID=?");
			$sql1->bindParam(1,$iduser);
			$sql1->execute();
			if($sql1->rowCount()>0){
				echo("<label>Rol actual del usuario:"."</label><br>");
		    ?><table align="left">
            <?php
			 foreach($sql1->fetchAll() as $fila){
				 ?>
                 <td border="2"><?php echo "<label>". strtoupper($fila["nombreRol"])."</label>";?></td>
                 <?php
				 }
				 ?>
                 </table>
                 <br>
                 <br>
               <?php
			}
			else{
				echo("<label>El usuario no tiene ningun rol asignado</label><br>");
				}
	 echo("<input type=submit value='Volver a listado de usuarios' onClick='history.back();' id=button>");
		 }
		 ?>
          <fieldset id="content">
           <legend>Listado de Permisos de acceso</legend>
           <table  id="tablepermission" align="left">
                        <thead>
                        <tr>
                        <th><label>Nombre de Rol</label></th>
                        <th ><label>Descripcion</label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
         <?php
             $sql2=$dbh->prepare("Select *from rol");
		     $sql2->execute();
			 if($sql2->rowCount()>0){
			   $fila=$sql2->rowCount();
				foreach($sql2->fetchAll() as $rol){
				$idrol=$rol[0];
				?>
                     <tr> 
                     <td><?php echo($rol[0]);?></td>
                     <td><?php echo($rol[1]);?></td>
<td align="center"><input type="hidden" value="<?php echo($idrol)?>" id="idrol"><input type="hidden" id="iduser" value="<?php echo($iduser)?>"><input type="button" tipoPerm="<?php echo $idrol;?>" onclick="fun('<?php echo $idrol;?>'); return false;" class="submit classPermisos" value="Asignar Rol" id="button"></td>
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