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
	if(isset($_POST["Nroentrada"])){
		require_once("../../db/connect.php");
		$nroEntrada=$_POST["Nroentrada"];
		$proveedor=$_POST["Proveedor"];
		$sql=$dbh->prepare("SELECT descripcion, m.unidad, cant_disponible
                            FROM material AS m, det_entrada AS d, entrada AS e, proveedor AS pv
                            WHERE m.IDmaterial = d.IDmaterial
                            AND d.IDentrada = e.IDentrada
                            AND e.IDproveedor = pv.IDproveedor
							and d.IDentrada=?
							and pv.empProveedora=?");
		$sql->bindParam(1,$nroEntrada);
		$sql->bindParam(2,$proveedor);
		$sql->execute();
		if($sql->rowCount()>0){
			$total=0;
			?>
            <label>Nro de entrada de almacén: </label><?php echo $nroEntrada; ?><br>
            <label>Proveedor: </label><?php echo $proveedor;?><br>
            <table id="tableuser">
          <th><label>Descripción</label></th>
          <th><label>Unidad de medida</label></th>
          <th><label>Cantidad en almacén</label></th>
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
                <td colspan="2" bgcolor="#999999"><label>Total almacenado</label></td><td align="center" bgcolor="#999999"><?php echo $total;?></td>
              </table>
                <?php
			}else{
				echo "No se encontraron resultados<br>";
				echo "Presione el botón Registrar para listar la entrada";
				}
		}
	}else{
		header("location: ../../index.php");
		}
?>