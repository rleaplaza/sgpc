<?php session_start();//función de inicio de sesión?>
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
					url: 'registros/addCotizacion.php',//url destino para registrar la cotización
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //campos del formulario nro y nro de solicitud de cotización
						    Nro:document.id('nro').value || 'nro de cotizacion no almacenado',
							NroSol:document.id('nrosol').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de cotización'//título de la ventana
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaCotizacion.php',//url destino para la consulta de cotizaciones
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura del nro de solicitud
							NroSol:document.id('nrosol').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Consulta de cotización'//título de la ventana
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){//verifica si la sesión existe
	require_once("../db/connect.php");//llama a la conexión
	require_once("registros/regAuditoria.php");
	require_once("registros/genNumero.php");//archivo para generar el numero de cotización
	$user=$_SESSION["username"];
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
		$nrosolicitud=$_GET["nro"];//captura el nro de solicitud
		$proveedor=$_GET["idproveedor"];//captura el id del proveedor
		$sql1=$dbh->prepare("SELECT distinct cotizacion.nro_cotizacion
                             FROM cotizacion, det_cotizacion
                             WHERE cotizacion.nro_cotizacion = det_cotizacion.nro_cotizacion
                             AND nro_solicitud=?");
		$sql1->bindParam(1,$nrosolicitud);
		$sql1->execute();
		if($sql1->rowCount()>0){
			$result=$sql1->fetch();
			$nro=$result["nro_cotizacion"];
			}
			else{
		$nro=generaNumero();//genera el nro de la cotización
		$sql=$dbh->prepare("insert into cotizacion values(?,?,?,curdate(),curtime())");
		$sql->bindParam(1,$nro);
		$sql->bindParam(2,$nrosolicitud);
		$sql->bindParam(3,$proveedor);
		$sql->execute();
			}
		
		//consulta el nombre de la empresa proveedora
		$consultaProveedor=$dbh->prepare("select empProveedora from proveedor where IDproveedor=?");
		$consultaProveedor->bindParam(1,$proveedor);
		$consultaProveedor->execute();
		$reg=$consultaProveedor->fetch();
		$prov=$reg["empProveedora"];
		#consulta de la fecha y hra de registro de la cotización
			$read=$dbh->prepare("select fecRegistro, hraRegistro from cotizacion where nro_cotizacion=?");
			$read->bindParam(1,$nro);
			$read->execute();
			$fila=$read->fetch();
			$fecha=$fila["fecRegistro"]." ".$fila["hraRegistro"];
		}
		else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
	?>
    <fieldset>
    <legend>FORMULARIO DE REGISTRO DE COTIZACIONES</legend>
    <a href="<?php echo "../reportes/compraAlquiler/ordenCompra.php?nro=$nro&prov=$prov&user=$user&fecha=$fecha";?>"><img src="../images/pdf.jpg" height="20" width="20"></a>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nro de cotización</label></td><td><input type="text"  class="nro" name="nro" id="nro" value="<?php echo $nro;?>" readonly></td></tr></div>
    <div><tr><td><label>Fecha</label></td><td><input type="text" name="fecha" id="fecha" class="fecha" value="<?php echo $fecha;?>" readonly></td></tr></div>
    <div><tr><td><label>Proveedor</label></td><td><input type="text" name="proveedor" id="proveedor" class="proveedor" value="<?php echo $prov;?>" readonly></td></tr></div>
    <div><tr><td><label>Nro de solicitud de cotización</label></td><td><input type="text" name="nrosol" id="nrosol" value="<?php echo $nrosolicitud;?>" readonly></td></tr></div>
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