<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cotización</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

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
</head>

<body>
<?php
if(isset($_SESSION["username"])){
try{
	require_once("../../db/connect.php");
	$consulta=$dbh->prepare("SELECT DISTINCT empProveedora
                             FROM pedido_material AS p, det_pedido AS dp, material AS m, proveedor AS pv
                             WHERE pv.IDproveedor = m.IDproveedor
                             AND m.IDmaterial = dp.IDmaterial
                             AND dp.IDpedido = p.IDpedido");
	$consulta->execute();
	$res=$consulta->fetch();
	$proveedor=$res[0];
		?>
        <img src="../../images/pedido.jpg" width="50" height="50" />
        <h2><legend>LISTADO DE PEDIDOS</legend></h2>
        <input type="submit" value="Volver al listado de materiales" onClick="history.back();" id="button"><br>
        
        <table id="tableMaq" width="814" align="left">
      <thead>
            	<tr>
           <th width="50"><label>Fecha de pedido</label></th>
           <th width="90"><label>Subtotal</label></th>
           <th width="80"><label>Impuesto Iva 13</label></th>
           <th width="50"><label>Total</label></th>
           <th width="50"><label>Estado</label></th>
           <th width="100"></th>
                </tr>
       </thead>

        <?php
		$sql=$dbh->prepare("select *from pedido_material");
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$idpedido=$row[0];
				?>
                <tr>
                <td><?php echo $row[6]. " ".$row[7];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4];?></td>
                <td align="center"><?php echo $row[5];?></td>
                <td align="center"><a href="<?php echo "detPedido.php?idpedido=$idpedido&proveedor=$proveedor";?>">Consultar detalle</a></td></tr>
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