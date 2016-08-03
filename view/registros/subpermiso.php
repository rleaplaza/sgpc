<?php
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asignacion de permisos</title>

<script type="text/javascript" src="../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablepermission").dataTable();
        });
   </script>
   
<script type="text/javascript" src="lightface/Source/mootools.js"></script>
<script type="text/javascript" src="lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="lightface/Source/LightFace.Request.js"></script>

<script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idPagina = param;
			ajaxFace = new LightFace.Request({
				url: 'setsubpermiso.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						codPagina: idPagina || 'Id de opcion no ingresado',
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
			var idPagina = param;
			ajaxFace = new LightFace.Request({
				url: 'desactivarsubPermiso.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { //captura el id de subpermiso y el id de usuario
						codPagina: idPagina || 'Id de opcion no ingresado',
						IDusuario:document.id('iduser').value || 'Id de usuario no ingresado'
					},
					method: 'post'
				},
				title: 'Desactivar Permiso'
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
				 #button1{
				
				font-wight:bold;
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
		 require_once("../../db/connect.php");//llama a la conexion global
		 $iduser=$_GET["iduser"];//captura el id de usuario
		 $idopcion=$_GET["idopcion"];//captura el id de opcion
		 $sql=$dbh->prepare("select username, rol.IDrol from usuario,rol 
		                     where usuario.IDrol=rol.IDrol 
		                     and USR_UID=?");
		 $sql->bindParam(1,$iduser);
		 $sql->execute();
		 if($sql->rowCount()>0){
			 $row=$sql->fetch();
			 $username=$row[0];
	 echo("<label>USER ID: " .$iduser. " <br> Username: ".$username  ."  <br> Rol: ".$row[1]."</label><br>");
	 echo("<input type=submit value='Volver a permisos' onClick='history.back();' id=button>");
		 }
		 ?>
          <fieldset id="content">
           <legend>Listado de Permisos de acceso</legend>
          <table id="tablepermission" align="center" width="800">
                        <thead>
                        <tr>
                        <th width="180"><label>Codigo de pagina</label></th>
                        <th width="180"><label>Nombre de pagina</label></th>
                        <th></th>
                        <th></th>
                        </tr>
                        </thead>
         <?php
 $sql2=$dbh->prepare("SELECT IDpagina, nombre from pagina_opcion where IDopcion=?");
 $sql2->bindParam(1,$idopcion);
				$sql2->execute();
				if($sql2->rowCount()>0){
					$fila=$sql2->rowCount();
					foreach($sql2->fetchAll() as $pagina){
						$idpagina=$pagina[0];
						?>
                       <tr> 
                        <td><?php echo($pagina[0]);?></td>
                        <td><?php echo($pagina[1]);?></td>
<td><input type="hidden" value="<?php echo($idpagina)?>" id="idopcion"><input type="hidden" id="iduser" value="<?php echo($iduser)?>"><input type="button" tipoPerm="<?php echo $idpagina;?>" onclick="fun('<?php echo $idpagina;?>'); return false;" class="submit classPermisos" value="Asignar Subpermiso" id="button"></td>
<td><input type="hidden" value="<?php echo($idopcion)?>" id="idopcion"><input type="hidden" id="iduser" value="<?php echo($iduser)?>"><input type="button" tipoPerm="<?php echo $idpagina;?>" onclick="fun1('<?php echo $idpagina;?>'); return false;" class="submit classPermisos" value="Eliminar SubPermiso" id="button1"></td>
                      
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