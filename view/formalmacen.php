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
					url: 'registros/addAlmacen.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    Nroentrada:document.id('nroentrada').value || 'nro de cotizacion no almacenado',
							Nronota:document.id('nronota').value || 'nro de solicitud no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de almacén'
				}).open();
				
			});
			
		});    
</script>
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub1').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaAlmacen.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
							Nroentrada:document.id('nroentrada').value || 'nro de solicitud no almacenado',
							Proveedor:document.id('proveedor').value || 'Proveedor no almanenado'
						},
						method: 'post'
					},
					title: 'Consulta de almacén'
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
	require_once("registros/generaNumero.php");
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
		echo("<label>Menu: <b>".$row["nombremenu"]."</b></label> ");
		echo("<label>Submenu: <b>". $row["nombresubmenu"]."</b></label> ");
		echo("<label>Opcion: <b>".$row["nombreopcion"]."</b></label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		//require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		//$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/nota.jpg" height="40" width="40"><br>
        <input type="submit" value="Volver al listado de solicitudes" onClick="history.back()" id="button"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para registrar entradas de materiales en almacén, presionar el botón Registrar, seguidamente, presionar el botón Consultar para desplegar la ventana del detalle. 
Para imprimir en informe, presionar sobre la imagen PDF correspondiente">
        <?php
		$nronota=$_GET["nronota"];
		$proveedor=$_GET["proveedor"];
		//selecciona al proveedor
		$query=$dbh->prepare("select IDproveedor from proveedor where empProveedora=?");
		$query->bindParam(1,$proveedor);
		$query->execute();
		$reg=$query->fetch();
		$idproveedor=$reg["IDproveedor"];
		//selecciona la nota de remisión
		$sql1=$dbh->prepare("select *from entrada where nro_nota=?");
		$sql1->bindParam(1,$nronota);
		$sql1->execute();
		
		if($sql1->rowCount()>0){
			$result=$sql1->fetch();
			$numEntrada=$result[0];
			}else{
		
		$numEntrada=generaNumero();
		$sql=$dbh->prepare("insert into entrada values(?,?,curdate(),?)");
		$sql->bindParam(1,$numEntrada);
		$sql->bindParam(2,$idproveedor);
		$sql->bindParam(3,$nronota);
		$sql->execute();
			}
		
		//consulta la fecha de registro del almacén
			$read=$dbh->prepare("select fecRegistro from entrada where IDentrada=?");
			$read->bindParam(1,$numEntrada);
			$read->execute();
			$fila=$read->fetch();
			$fecha=$fila["fecRegistro"];
			
		}
		else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
	?>
    <fieldset>
   <a href="<?php echo "../reportes/compraAlquiler/rAlmacen.php?nroentrada=$numEntrada&proveedor=$proveedor"?>" target="_blank"><img src="../images/pdf.jpg" height="25" width="25" title="IMPRIMIR EN PDF"></a>
    <legend>FORMULARIO DE REGISTRO DE NOTAS DE REMISIÓN</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Nro de entrada</label></td><td><input type="text"  class="nroentrada" name="nroentrada" id="nroentrada" value="<?php echo $numEntrada;?>" readonly></td></tr></div>
    <input type="hidden" value="<?php echo $proveedor;?>" id="proveedor" name="proveedor">
    <div><tr><td><label>Fecha</label></td><td><input type="text" name="fecha" id="fecha" class="fecha" value="<?php echo $fecha;?>" readonly></td></tr></div>
    <div><tr><td><label>Proveedor</label></td><td><input type="text" name="proveedor" id="proveedor" class="proveedor" value="<?php echo $proveedor;?>" readonly></td></tr></div>
    <div><tr><td><label>Nro de nota de remisión</label></td><td><input type="text" name="nronota" id="nronota" value="<?php echo $nronota;?>" readonly></td></tr></div>
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