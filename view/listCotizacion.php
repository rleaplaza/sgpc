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
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" src="../js/cargarUnidad.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableMaq").dataTable({
				"sScrollY":"200px",
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
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addSolCot.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDmaterial:document.id('material').value || 'nombre no agregado',
							Cantidad:document.id('cantidad').value || 'cargo no ingresado',
							Nro:document.id('nro').value || 'Nro no almacenado'
						},
						method: 'post'
					},
					title: 'Solicitud de cotización'
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub2').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaDetSolC.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDmaterial:document.id('material').value || 'nombre no agregado',
							Nro:document.id('nro').value || 'Nro no almacenado'
							
						},
						method: 'post'
					},
					title: 'Consulta de detalle de solicitud'
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub3').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'delete/deleteDetalleSC.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDmaterial:document.id('material').value || 'nombre no agregado',
							Nro:document.id('nro').value || 'cargo no ingresado'
						},
						method: 'post'
					},
					title: 'Cancelar solicitud'
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
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
			#button:hover{
				background:#ddd;
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
        <link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
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
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		if(isset($_POST["proveedor"])){
		$proveedor=$_POST["proveedor"];
		$consulta=$dbh->prepare("select empProveedora from proveedor where IDproveedor=?");
		$consulta->bindParam(1,$proveedor);
		$consulta->execute();
		$res=$consulta->fetch();
	    $provider=$res["empProveedora"];
		//generar la solicitud de cotizacion
		require_once("registros/genNumero.php");
		$nro=generaNumero();
		$insert=$dbh->prepare("insert into solicitud_cotizacion values(?,curdate(),?)");
		$insert->bindParam(1,$nro);
		$insert->bindParam(2,$proveedor);
		$insert->execute();
		}
	}
	else{
		header("location: ../index.php");
		}
		?>
        <br><idmg src="../images/cotizador.jpg" width="50" height="50" /><br><input type="submit" value="VOLVER AL FORMULARIO PRINCIPAL" onClick="history.back()" id="button"><br>
               <label>Ayuda del sistema</label></td><td><img src="../images/ayuda.jpg" width="20" height="20" title="Para realizar solicitudes, llenar el formulario y presionar el botón registrar.
Presionar el botón consultar para mostrar el detalle de la solicitud, presionar cancelar para eliminar el elemento registrado.
Para enviar la solicitud por email, presionar la imagen PDF, adjuntarlo en el campo archivo y presionar el botón Enviar solicitud">
        <table>
        <tr><td><label>Proveedor:</label></td><td><?php echo $provider;?></td><td><label>Nro de solicitud:</label></td><td><?php echo $nro;?></td></tr>
        <tr><td><label>Fecha de solicitud:</label></td><td><?php $sql=$dbh->prepare("select fecha from solicitud_cotizacion where nro_solicitud=?");
		$sql->bindParam(1,$nro);
		$sql->execute();
		$res=$sql->fetch();
		$fecha=$res["fecha"];
		echo $fecha;?></td></tr>
        </table> 
       <a href="<?php echo "../reportes/compraAlquiler/solCotizacion.php?proveedor=$provider&nro=$nro&user=$user"?>" target="_blank"><img src="../images/pdf_1.jpg" width="30" height="30" title="Imprimir el documento pdf" /></a> 
    <fieldset>
    <?php
	   //consulta del email del proveedor seleccionado
       $qemail=$dbh->prepare("SELECT email FROM usuario, proveedor WHERE usuario.USR_UID = proveedor.USR_UID
	                         and empProveedora=?");
	   $qemail->bindParam(1,$provider);
	   $qemail->execute();
	   $reg=$qemail->fetch();
	   $email=$reg["email"];
	   ?>
    <legend>FORMULARIO DE SOLICITUD DE COTIZACIÓN</legend>
       <form class="usuario" method="post" enctype="multipart/form-data">
       <table>
       <tr><td><label>Correo del proveedor: </label><?php echo $email;?></td></tr>
       <td><label>Adjuntar archivo de solicitud</label><input type="file" class="archivo" name="archivo" required></td><td>
       
       <input type="hidden" name="email" value="<?php echo $email;?>">
       <input type="submit" value="Enviar solicitud" onClick="this.form.action='registros/sendMessage.php'"></td>
</form> 
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <tr><td><label>Material</label></td><td><select name="material" class="material" id="material" onChange="cargarUnidad(this.value)">
    <?php
    $sql=$dbh->prepare("select *from material order by descripcion asc");
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
   <tr><td><label>Unidad</label></td><td><div id="unidad"><input type="text" name="unidad" class="unidad" readonly></div></td></tr>
    <tr><td><label>Cantidad a solicitar</label></td><td><input type="text" name="cantidad" id="cantidad" class="cantidad" placeholder="5" maxlength="3"><img src="../images/ayuda.jpg" height="20" width="20" title="Escriba un valor numérico entero"></td></tr>
    <input type="hidden" id="nro" value="<?php echo $nro;?>">
 <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input type="button" class="boton_envio" id="sub2" value="CONSULTAR"></td><td><input type="button" class="boton_envio" id="sub3" value="CANCELAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
  
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