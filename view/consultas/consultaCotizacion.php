<?php session_start()?>
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
	if(isset($_POST["NroSol"])){
		require_once("../../db/connect.php");
		$nroSol=$_POST["NroSol"];
		$sql=$dbh->prepare("SELECT material.descripcion, cantidad_sol, material.unidad, precio_unitario, subtotal
                            FROM material, cotizacion, det_cotizacion
                            WHERE cotizacion.nro_cotizacion = det_cotizacion.nro_cotizacion
                            AND det_cotizacion.IDmaterial = material.IDmaterial
                            AND nro_solicitud = ?");
		$sql->bindParam(1,$nroSol);
		$sql->execute();
		if($sql->rowCount()>0){
			$total=0;
				echo "<label>Nro de solicitud: </label>".$nroSol;
			?>
            <table>
            <th><label>Descripción</label></th>
            <th><label>Cantidad cotizada</label></th>
            <th><label>Unidad de medida</label></th>
            <th><label>Precio unitario</label></th>
            <th><label>Subtotal</label></th>
            <?php
            foreach($sql->fetchAll() as $row){
				$total=$total+$row[4];
				?>
              <tr><td><?php echo $row[0];?></td>
                  <td align="center"><?php echo $row[1];?></td>
                  <td align="center"><?php echo $row[2];?></td>
                  <td align="center"><?php echo $row[3];?></td>
                  <td align="center"><?php echo $row[4];?></td></tr>
                  
                <?php
				}
			?>
            <td colspan="4"><label>Total cotizado</label></td><td align="center"><?php echo $total;?></td>
            </table>
            <?php
			}else{
				echo "Ningún resultado encontrado";
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>