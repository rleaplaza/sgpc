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
	if(isset($_POST["IDmaterial"])){
		require_once("../../db/connect.php");
		$idmaterial=$_POST["IDmaterial"];
		$nro=$_POST["Nro"];
		//consulta el detalle
		$sql=$dbh->prepare("SELECT descripcion, m.unidad, cantidad_sol
                            FROM material AS m, det_solicitud_cotizacion AS d, solicitud_cotizacion AS s
                            WHERE m.IDmaterial = d.IDmaterial
                            AND d.nro_solicitud = s.nro_solicitud
							and s.nro_solicitud=?");
		$sql->bindParam(1,$nro);
		$sql->execute();
		if($sql->rowCount()>0){
			$total=0;
			?>
          <label>Solicitud nro: </label><?php echo $nro;?>
          <table>
          <th><label>Descripción</label></th>
          <th><label>Unidad de medida</label></th>
          <th><label>Cantidad solicitada</label></th>
            <?php
		foreach($sql->fetchAll() as $row){
			$total=$total+$row[2];
			?>
            <tr><td><?php echo $row[0];?></td>
            <td align="center"><?php echo $row[1];?></td>
            <td align="center"><?php echo $row[2];?></td></tr>
            <?php
			}
			?>
             <td colspan="2"><label>Total solicitado</label></td><td align="center"><?php echo $total;?></td>
              </table>
            <?php
		}
		
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>