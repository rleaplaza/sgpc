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
	if(isset($_POST["Nrocotizacion"])){
		require_once("../../db/connect.php");
		try{
			$nrocotizacion=$_POST["Nrocotizacion"];
			$consulta=$dbh->prepare("select nro_pedido, iva, total from pedido_material where nro_cotizacion=? and estado='Atendido'");
			$consulta->bindParam(1,$nrocotizacion);
			$consulta->execute();
			$registro=$consulta->fetch();
			$nropedido=$registro["nro_pedido"];
			
			$sql=$dbh->prepare("SELECT m.descripcion, d.cantidad, d.unidad, d.precio, d.subtotal
                                FROM material AS m, det_pedido AS d, pedido_material AS p
                                WHERE m.IDmaterial = d.IDmaterial
                                AND d.nro_pedido = p.nro_pedido
                                AND p.nro_pedido =?");
			$sql->bindParam(1,$nropedido);
			$sql->execute();
			if($sql->rowCount()>0){
				$subtotal=0;
				?>
                  <table>
            <th><label>Descripción</label></th>
            <th><label>Cantidad</label></th>
            <th><label>Unidad de medida</label></th>
            <th><label>Precio unitario</label></th>
            <th><label>Subtotal</label></th>
                <?php
				echo "<label>Nro de pedido: </label>". $nropedido;
				foreach($sql->fetchAll() as $row){
					$subtotal=$subtotal+$row[4];
				?>
              <tr><td><?php echo $row[0];?></td>
                  <td align="center"><?php echo $row[1];?></td>
                  <td align="center"><?php echo $row[2];?></td>
                  <td align="center"><?php echo $row[3];?></td>
                  <td align="center"><?php echo $row[4];?></td></tr>
                <?php
				}
				$iva=$subtotal*0.13;
				$total=$subtotal-$iva;
				?>
                <tr><td colspan="4"><label>Subtotal</label></td><td align="center"><?php echo $subtotal;?></td></tr>
                <tr><td colspan="4"><label>Iva</label></td><td align="center"><?php echo $iva;?></td></tr>
                <tr><td colspan="4"><label>Total pedido</label></td><td align="center"><?php echo $total;?></td></tr>
            </table>
                <?php
				}else{
					echo "Detalle no encontrado";
					}
			
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
