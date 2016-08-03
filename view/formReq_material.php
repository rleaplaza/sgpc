<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de solicitud de cotización</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/cargarUnidad.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>  
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addReq_material.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDproyecto:document.id('idproyecto').value || 'id no encontrado',
							Nro:document.id('nro').value || 'nro no encontrado',
							Fecha:document.id('fecha').value || 'fecha no encontrada',
							IDmaterial:document.id('idmaterial').value || 'ID no encontrado',
							Cantidad:document.id('cantidad').value || 'Valor no encontrado'
						},
						method: 'post'
					},
					title: 'Requerimiento de materiales'
				}).open();
			});
			
		});    
</script>

   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			  #button{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#FFF;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#00C;
				border-radius:8px 8px 8px 8px;
			}
			#button:hover{
				background:#999;
			}
					text{
			  font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  font-size:13px;
				 }
					     label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;  #button{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
		</style>
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
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
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
    $user=$_SESSION["username"];
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
			
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		}
		require_once("registros/genNumero.php");
		$nro=generaNumero();
		}
	else{
		header("location: ../index.php");
		}
		?>
        <br><input type="submit" value="Salir" onClick="history.back()" id="button"><br>
               <label>Ayuda del sistema</label></td><td><img src="../images/ayuda.jpg" width="20" height="20" title="Para realizar solicitudes, llenar el formulario y presionar el botón registrar.
Presionar el botón consultar para mostrar el detalle de la solicitud, presionar cancelar para eliminar el elemento registrado.
Para enviar la solicitud por email, presionar la imagen PDF, adjuntarlo en el campo archivo y presionar el botón Enviar solicitud">
      <?php
      $idproyecto=$_POST["proyecto"];
	  $query=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	  $query->bindParam(1,$idproyecto);
	  $query->execute();
	  if($query->rowCount()>0){
		  $reg=$query->fetch();
		  $proyecto=$reg[0];
		  }
	  ?> 
       
    <fieldset>
    <legend>Formulario de requerimiento de materiales</legend> 
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <tr><td><label>Número de requerimiento</label></td><td><input type="text" name="nro" id="nro" readonly value="<?php echo $nro;?>"></td></tr>
    <tr><td><label>Fecha</label></td><td><?php $sql=$dbh->prepare("select curdate()");
		$sql->execute();
		$res=$sql->fetch();
		$fecha=$res[0];
		?>
		<input type="text" readonly id="fecha" name="fecha" value="<?php echo $fecha;?>"></td></tr>
    <tr><td><label>Proyecto</label></td><td><textarea name="proyecto" class="proyecto" readonly cols="3" rows="2"><?php echo $proyecto;?></textarea></td></tr>
    <input type="hidden" id="idproyecto" name="idproyecto" value="<?php echo $idproyecto;?>">
    <tr><td><label>Material</label></td><td><select name="material" class="material" id="idmaterial" onChange="cargarUnidad(this.value)">
    <?php
	$proveedor=$_POST["proveedor"];
    $sql=$dbh->prepare("select *from material where IDproveedor=? order by descripcion asc");
	$sql->bindParam(1,$proveedor);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $fila){
		?>
        <option value="<?php echo $fila["IDmaterial"]?>"><?php echo $fila["descripcion"];?>
        <?php
		}
	}
	?>
    </select></td></tr>
   <tr><td><label>Unidad</label></td><td><div id="unidad"><input type="text" id="unidad" name="unidad" class="unidad" readonly required></div></td></tr>
    <tr><td><label>Cantidad a solicitar</label></td><td><input type="text" name="cantidad" id="cantidad" class="cantidad" maxlength="5" required><img src="../images/ayuda.jpg" height="20" width="20" title="Escriba un valor numérico entero"></td></tr>
    <input type="hidden" id="nro" value="<?php echo $nro;?>">
 <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td></tr>
  
    </table>
    </form>
    </fieldset>
        
        <?php
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		
		}
}else{
	header("location: index.php");
	}
?>
</body>
</html>