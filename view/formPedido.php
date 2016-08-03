<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro de cotización</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	    #button{font-wight:bold;
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
	   </style>
          <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addPedido.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    Nropedido:document.id('nropedido').value || 'nro de cotizacion no almacenado',
							Nrocotizacion:document.id('nrocotizacion').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de pedido'
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaPedido.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							Nrocotizacion:document.id('nrocotizacion').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Consulta de detalle de pedido'
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	require_once("registros/genNumero.php");
	//consulta el programa donde el usuario se encuentra actualmente
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al parámetro de la condición
	$consulta->execute();//ejecuta la sentencia sql
	if($consulta->rowCount()>0){
		$row=$consulta->fetch(); 
		//Muestra el programa donde el usuario se encuentra
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/cotizador.jpg" height="40" width="40"><br>
        <input type="submit" value="Volver al listado de solicitudes" onClick="history.back()" id="button"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		
			$query=$dbh->prepare("select IDempleado from empleado, usuario
		                      where empleado.CI=usuario.CI
							  and username=?");
		$query->bindParam(1,$_SESSION["username"]);
		$query->execute();
		$resultado=$query->fetch();
		$idempleado=$resultado["IDempleado"];
		//consulta el nro de cotización
		$nrocotizacion=$_GET["nro"];
	    $proveedor=$_GET["idproveedor"];
		$query1=$dbh->prepare("select *from pedido_material where nro_cotizacion=? and estado='Atendido'");
		$query1->bindParam(1,$nrocotizacion);
		$query1->execute();
		if($query1->rowCount()>0){
			$resultado1=$query1->fetch();
			$nroPedido=$resultado1["nro_pedido"];
			}else{
				//consulta del id de empleado encargado de compras
					//consulta el id del empleado encargado de compras
	
		//genera el numero del pedido en caso de que este no exista
		$nroPedido=generaNumero();
		$sql=$dbh->prepare("insert into pedido_material values(?,?,?,?,null,null,null,'Pendiente',curdate())");
		$sql->bindParam(1,$nroPedido);
		$sql->bindParam(2,$nrocotizacion);
		$sql->bindParam(3,$idempleado);
		$sql->bindParam(4,$proveedor);
		$sql->execute();
			}
		//captura el id del proveedor
	
		//consulta el nombre de la empresa proveedora
		$consultaProveedor=$dbh->prepare("select empProveedora from proveedor where IDproveedor=?");
		$consultaProveedor->bindParam(1,$proveedor);
		$consultaProveedor->execute();
		$reg=$consultaProveedor->fetch();
		$prov=$reg["empProveedora"];
	
		
		//inserta el pedido
		}
		else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
	?>
   
    <fieldset>
     <a href="<?php echo "../reportes/compraAlquiler/rdetpedido.php?prov=$prov&idproveedor=$proveedor&nrocot=$nrocotizacion"?>" target="_blank"><img src="../images/pdf_1.jpg" width="30" height="30" title="Exportar a pdf" /></a>
     <?php
       $qemail=$dbh->prepare("SELECT email FROM usuario, proveedor WHERE usuario.USR_UID = proveedor.USR_UID
	                         and empProveedora=?");
	   $qemail->bindParam(1,$prov);
	   $qemail->execute();
	   $reg=$qemail->fetch();
	   $email=$reg["email"];
	   ?> 
    <legend>FORMULARIO DE REGISTRO DE PEDIDOS</legend>
    <form class="usuario" method="post" enctype="multipart/form-data">
       <table>
       <tr><td><label>Correo del proveedor: </label><?php echo $email;?></td></tr>
       <td><label>Adjuntar archivo de solicitud</label><input type="file" class="archivo" name="archivo" required></td><td>
       
       <input type="hidden" name="email" value="<?php echo $email;?>">
       <input type="submit" value="Enviar pedido" onClick="this.form.action='registros/sendPedido.php'"></td>
</form> 
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
     <div><tr><td><label>Nro de pedido</label></td><td><input type="text"  class="nropedido" name="nropedido" id="nropedido" value="<?php echo $nroPedido;?>" readonly></td></tr></div>
    <div><tr><td><label>Nro de cotización</label></td><td><input type="text"  class="nrocotizacion" name="nrocotizacion" id="nrocotizacion" value="<?php echo $nrocotizacion;?>" readonly></td></tr></div>
    <input type="hidden" id="idempleado" name="idempleado" value="<?php echo $idempleado;?>">
    <div><tr><td><label>Proveedor</label></td><td><input type="text" name="proveedor" id="proveedor" class="proveedor" value="<?php echo $prov;?>" readonly></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="boton_envio" type="button" id="sub1" value="CONSULTAR"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>