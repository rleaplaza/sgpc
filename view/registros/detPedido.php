<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cotización</title>
<script type="text/javascript" src="../../js/jquery.min.js"></script>

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../../js/tabber.js"></script>

<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableMaq").dataTable({
				"sScrollY":"200px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../../traducciones/datatables.spanish.txt"
					}
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
			var idmat = param;
			ajaxFace = new LightFace.Request({
				url: '../delete/deleteDet.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDmat: idmat || 'Id de opcion no ingresado',
						IDpedido:document.id('idpedido') || 'Dato no almacenado'
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
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			  #button{
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
	#button:hover{
				background:#ddd;
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
        <link href="../../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if(isset($_SESSION["username"])){
try{
	require_once("../../db/connect.php");
	$idpedido=$_GET["idpedido"];
	$proveedor=$_GET["proveedor"];
		?>
<img src="../../images/pedido.jpg" width="50" height="50"/><a href="<?php echo "../../reportes/compraAlquiler/rdetPedido.php?idpedido=$idpedido&proveedor=$proveedor"?>" target="_blank"><img src="../../images/pdf.jpg" height="50" width="50" title="Imprimir detalle en pdf"></a>
        <h2><legend>DETALLE DE PEDIDO</legend></h2>
        <input type="submit" value="Volver al listado de materiales" onClick="history.back();" id="button1"><br>
        
        <table id="tableMaq" width="814" align="left">
      <thead><tr>
           <th width="50"><label>Descripción</label></th>
           <th width="90"><label>Cantidad a solicitar</label></th>
           <th width="80"><label>Precio unitario</label></th>
           <th width="50"><label>Subtotal</label></th>
           <th width="100"></th>
           <th width="100"></th>
                </tr>
       </thead>

        <?php
		$sql=$dbh->prepare("SELECT m.IDmaterial, descripcion, d.cantidad, d.precio, d.subtotal, p.IDpedido, empProveedora
                            FROM material AS m, pedido_material AS p, det_pedido AS d, proveedor AS pv
                            WHERE m.IDmaterial = d.IDmaterial
                            AND m.IDproveedor = pv.IDproveedor
                            AND p.IDpedido = d.IDpedido
                            and p.IDpedido=?");
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
                <td align="center"><a href="<?php echo "editDet.php?idmaterial=$idmaterial&idpedido=$row[5]";?>">Editar cantidad</a></td>
                 <td align="center"> 
                 <input type="hidden" id="idpedido" value="<?php echo $row[5];?>">
                 <input type="button" tipoPerm="<?php echo $idmaterial;?>" onclick="fun('<?php echo $idmaterial;?>'); return false;" class="submit classPermisos" value="ELIMININAR DE PEDIDO" id="button"></td></tr>
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