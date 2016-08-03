<?php session_start();//inicio de la sesión?>
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
				ajaxFace = new LightFace.Request({//instancia a la clase lightface request para datos de formulario
					url: 'registros/addNotaRemision.php',//url destino para registrar la nota de remisión
					buttons: [//botón para cerrar la ventana
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //datos del nro de nota y nro de pedido
						    Nronota:document.id('nronota').value || 'nro de cotizacion no almacenado',
							Nropedido:document.id('nropedido').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Nota de remisión'
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			document.id('sub1').addEvent('click',function(){
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaRemision.php',//url para consultar la nota de remisión
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							Nronota:document.id('nronota').value || 'nro de solicitud no almacenado',
							Proveedor:document.id('proveedor').value || 'Proveedor no almanenado'
						},
						method: 'post'
					},
					title: 'Consulta de nota de remisión'
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
        <img src="../images/nota.jpg" height="40" width="40"><br>
        <input type="submit" value="Volver al listado de solicitudes" onClick="history.back()" id="button"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		$nropedido=$_GET["nropedido"];//captura del nro de pedido
		$idproveedor=$_GET["proveedor"];//captura del id de proveedor
		$sql1=$dbh->prepare("select *from nota_remision where nro_pedido=?");//consulta de la nota de remisión en base al nro del pedido
		$sql1->bindParam(1,$nropedido);//enlaza al nro de pedido
		$sql1->execute();
		if($sql1->rowCount()>0){
			$result=$sql1->fetch();
			$numNota=$result[0];//si existe el resultado se almacena el nro de nota para evitar pre registro de notas de remisión
			}else{
		$numNota=generaNumero();//caso contrario genera el nro de la nota de remisión
		#registro de la nota de remisión
		$sql=$dbh->prepare("insert into nota_remision values(?,curdate(),?,?)");
		$sql->bindParam(1,$numNota);
		$sql->bindParam(2,$idproveedor);
		$sql->bindParam(3,$nropedido);
		$sql->execute();
			}
		//consulta el nombre de la empresa proveedora
		$consultaProveedor=$dbh->prepare("select empProveedora from proveedor where IDproveedor=?");
		$consultaProveedor->bindParam(1,$idproveedor);
		$consultaProveedor->execute();
		$reg=$consultaProveedor->fetch();
		$prov=$reg["empProveedora"];
		//inserta la cotización
		
		
			$read=$dbh->prepare("select fecha from nota_remision where nro_nota=?");
			$read->bindParam(1,$numNota);
			$read->execute();
			$fila=$read->fetch();
			$fecha=$fila["fecha"];
			
		}
		else{
			header("location: ../index.php");//redirige al login
			}
	}else{
		header("location: ../index.php");//redirige al login
		}
	?>
    <fieldset>
     <a href="<?php echo "../reportes/compraAlquiler/notaRemision.php?numNota=$numNota&prov=$prov&nropedido=$nropedido"?>" target="_blank"><img src="../images/pdf_1.jpg" height="25" width="25" title="IMPRIMIR EN PDF"></a>
    <legend>FORMULARIO DE REGISTRO DE NOTAS DE REMISIÓN</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nro de pedido</label></td><td><input type="text" name="nropedido" id="nropedido" value="<?php echo $nropedido;?>" readonly></td></tr></div>
    <input type="hidden" value="<?php echo $prov;?>" id="proveedor" name="proveedor">
    <div><tr><td><label>Fecha</label></td><td><input type="text" name="fecha" id="fecha" class="fecha" value="<?php echo $fecha;?>" readonly></td></tr></div>
    <div><tr><td><label>Proveedor</label></td><td><input type="text" name="proveedor" id="proveedor" class="proveedor" value="<?php echo $prov;?>" readonly></td></tr></div>
    <div><tr><td><label>Nro de nota de remisión</label></td><td><input type="text"  class="nronota" name="nronota" id="nronota" value="<?php echo $numNota;?>" readonly></td></tr></div>
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