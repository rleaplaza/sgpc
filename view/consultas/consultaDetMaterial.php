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
	if(isset($_POST["IDpedido"])){
		require_once("../../db/connect.php");
		$IDpedido=$_POST["IDpedido"];
		$IDactividad=$_POST["IDactividad"];
		#consulta del solicitante
		$consulta=$dbh->prepare("SELECT nombres, app, apm FROM empleado, personaltecnico, pedido_almacen
                                 WHERE empleado.CI = personaltecnico.CI
                                 AND personaltecnico.IDpersonalTecnico = pedido_almacen.IDpersonalTecnico
								 and pedido_almacen.Nro_pedido=?");
		$consulta->bindParam(1,$IDpedido);
		$consulta->execute();
		if($consulta->rowCount()>0){
			$result=$consulta->fetch();
			$nombre=$result[0]." ".$result[1]." ".$result[2];
			}
		#consulta del detalle
		$sql=$dbh->prepare("SELECT m.descripcion, dp.cantidad_sol, dp.unidad
                            FROM material AS m, det_pedido_almacen AS dp, pedido_almacen AS p, actividad AS a
                            WHERE m.IDmaterial = dp.IDmaterial
                            AND dp.Nro_pedido = p.Nro_pedido
                            AND p.IDactividad = a.IDactividad
							and a.IDactividad=?
							and p.Nro_pedido=?");
		$sql->bindParam(1,$IDactividad);
		$sql->bindParam(2,$IDpedido);
		$sql->execute();
		if($sql->rowCount()>0){
			?>
            <label>Solicitante </label><?php echo $nombre;?>
            <table>
            <th><label>Material</label></th>
            <th><label>Cantidad solicitada</label></th>
            <?php
			foreach($sql->fetchAll() as $fila){
				?>
                <tr><td><?php echo $fila[0];?></td>
                <td align="center"><?php echo $fila[1]." ".$fila[2];?></td></tr>
                <?php
				}
			}else{
				echo "No se encontraron resultados";
				}
			?>
            </table>
            <?php
		}else{
			header("../../index.php");
			}
	
	}else{
		header("../../index.php");
		}
?>
