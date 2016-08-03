<?php session_start();?>
<meta charset="utf-8">
<style>
		     label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
			 th{
				 background:#CCC;
				 }
</style>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nronota"])){
		require_once("../../db/connect.php");
		$nroNota=$_POST["Nronota"];
		$proveedor=$_POST["Proveedor"];
$sql=$dbh->prepare("SELECT m.descripcion, d.unidad, d.cantidad, d.precio
                    FROM material AS m, det_notaremision AS d, nota_remision AS n, pedido_material AS p, proveedor AS pv
                    WHERE m.IDmaterial = d.IDmaterial
                    AND d.nro_nota = n.nro_nota
                    AND pv.IDproveedor = n.IDproveedor
                    AND p.nro_pedido = n.nro_pedido
                    AND n.nro_nota = ?
                    AND empProveedora = ?");
$sql->bindParam(1,$nroNota);
$sql->bindParam(2,$proveedor);
$sql->execute();
if($sql->rowCount()>0){
	$prtotal=0;
	$subtotal=0;
	
	echo "<label>Proveedor: </label>".$proveedor."<br>";
	echo "<label>Nro de nota: </label>".$nroNota;
	?>
    <table>
          <th><label>Descripción</label></th>
          <th><label>Unidad de medida</label></th>
          <th><label>Cantidad solicitada</label></th>
          <th><label>Precio unitario</label></th>
          <th><label>SubTotal</label></th>
    <?php
	foreach($sql->fetchAll() as $row){
		$subtotal=$row[2]*$row[3];
		$prtotal=$prtotal+$subtotal;
		?>
        <tr><td><?php echo $row[0];?></td>
            <td align="center"><?php echo $row[1];?></td>
            <td align="center"><?php echo $row[2];?></td>
            <td align="center"><?php echo $row[3];?></td>
            <td align="center"><?php echo $subtotal;?></tr>
        <?php
		}
		?>
           <td colspan="4"><label>Total</label></td><td align="center"><?php echo $prtotal;?></td>
              </table>
        <?php
	}
		}
	}else{
		header("location: ../../index.php");
		}
?>
