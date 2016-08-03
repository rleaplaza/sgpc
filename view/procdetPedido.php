<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cotización</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
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
     <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/procPedido.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						   IDpedido:document.id('idpedido').value || 'Dato no almacenado',
						},
						method: 'post'
					},
					title: 'Proceso de pedido'
				}).open();
				
			});
			
		});    
</script>
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
	#button1:hover{
				background:#ddd;
					}
					#sub:hover{
				background:#ddd;
					}
					#sub{
						font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#00F;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
						}
					 #button1{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
					text{
				 font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  font-size:18px;
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
	require_once("../../db/connect.php");
	$idpedido=$_GET["idpedido"];
	$proveedor=$_GET["proveedor"];
		?>
<img src="../images/pedido.jpg" width="50" height="50"/>
        <h2><legend>DETALLE DE PEDIDO</legend></h2>
        <input type="submit" value="Volver al listado de pedidos" onClick="history.back();" id="button1">
        <input type="hidden" id="idpedido" value="<?php echo $idpedido;?>">
        <input type="button" id="sub" value="Procesar pedido">
        <table id="tableMaq" width="814" align="left">
      <thead><tr>
           <th width="50"><label>Descripción</label></th>
           <th width="90"><label>Cantidad a solicitar</label></th>
           <th width="80"><label>Precio unitario</label></th>
           <th width="50"><label>Subtotal</label></th>
                </tr>
       </thead>

        <?php
		$sql=$dbh->prepare("SELECT m.IDmaterial, descripcion, d.cantidad, d.precio, d.subtotal, p.nro_pedido,                            empProveedora
                            FROM material AS m, pedido_material AS p, det_pedido AS d, proveedor AS pv
                            WHERE m.IDmaterial = d.IDmaterial
                            AND m.IDproveedor = pv.IDproveedor
                            AND p.nro_pedido = d.nro_pedido                            
							and p.nro_pedido=?");
		$sql->bindParam(1,$idpedido);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$idmaterial=$row[0];
				?>
                <tr>
                <td align="center"><?php echo $row[1];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4];?></td>
                </tr>
                <?php
				}
		}
				?>
                </table>
            
                
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