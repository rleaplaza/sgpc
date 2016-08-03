<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="../registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
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
	   </style>
          <script src="../../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="../registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="../registros/lightface/Source/LightFace.Request.js"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'updateDet.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    Desc:document.id('desc').value || 'nombre no agregada',
							Cant:document.id('cantidad').value || 'cargo no ingresado',
							IDpedido:document.id('idpedido').value || 'Dato no almacenado',
							IDmaterial:document.id('idmaterial').value || 'Dato no almacenado',
							Precio:document.id('precio').value || 'Precio no almacenado'
						},
						method: 'post'
					},
					title: 'Edición de detalle de pedido'
				}).open();
				
			});
			
		});    
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	$idmaterial=$_GET["idmaterial"];
	$idpedido=$_GET["idpedido"];
	
	$sql=$dbh->prepare("select m.descripcion, unidad,cantidad ,precio from det_pedido as d, material as m
	                    where m.IDmaterial=d.IDmaterial
	                    and d.IDpedido=? 
						and m.IDmaterial=?");
	$sql->bindParam(1,$idpedido);
	$sql->bindParam(2,$idmaterial);
	$sql->execute();
	$res=$sql->fetch();
					
	?>
    <img src="../../images/pedido.jpg" height="25" width="25"><br>
    <input type="submit" value="Volver al detalle de pedido" onClick="history.back()" class="boton_envio" id="button">
    <fieldset>
    <label>FORMULARIO DE EDICIÓN DE DETALLE DE PEDIDO</label>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Descripción de material</label></td><td><input type="text"  class="desc" name="desc" id="desc" value="<?php echo $res[0];?>" disabled="disabled"></td></tr></div>
    <div><tr><td><label>Unidad</label></td><td><input type="text"  class="desc" name="desc" id="desc" value="<?php echo $res[1];?>" disabled="disabled"></td></tr></div>
    <div><tr><td><label>Cantidad</label></td><td><input type="text" name="cantidad" id="cantidad" class="cantidad" maxlength="3" value="<?php echo $res[2];?>"></td></tr></div>
   <input type="hidden" id="idpedido" value="<?php echo $idpedido;?>">
   <input type="hidden" id="idmaterial" value="<?php echo $idmaterial;?>">
   <input type="hidden" id="precio" value="<?php echo $res[2];?>">
  <tr><td><input type="button" class="boton_envio" id="sub" value="ACTUALIZAR"></td></tr>
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