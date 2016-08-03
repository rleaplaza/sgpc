<?php session_start();?>
<html>
<head><meta charset="utf-8"></head>
<style>
		     label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
			 th{
				 background:#CCC;
				 }
</style>
<?php
sleep(1);
require_once("../db/connect.php");
$IDcargom=$_POST["IDCargoM"];
$nombre=$_POST["NameCargo"];
$sql=$dbh->prepare("SELECT p.nombre, p.ap_p, p.ap_m, telefono,direccion, c.nombre FROM cargomanodeobra AS c, personalmanoobra AS p
                    WHERE c.IDcargoM = p.IDcargoM
				    AND c.IDcargoM=?
					order by p.nombre");
$sql->bindParam(1,$IDcargom);
$sql->execute();
?>
<img src="../images/cargoManoobra.jpg" height="30" width="30"><label><?php echo "Trabajadores del cargo: ";?></label><?php echo $nombre."<br>";?>
<?php
if($sql->rowCount()>0){
	?>

    <table>
   
<th><label>Trabajador</label></th>
<th><label>Teléfono</label></th>
<th><label>Dirección</label></th>

    <?php
	foreach($sql->fetchAll() as $row){
		?>
        <tr><td><?php echo $row[0]." ".$row[1]." ".$row[2];?></td>
        <td><?php echo $row[3];?></td>
         <td><?php echo $row[4];?></td></tr>
        <?php
		}
     $count=$dbh->prepare("SELECT count( * ) AS trabajadores, c.IDcargoM
                        FROM cargomanodeobra as c, personalmanoobra as p
                        WHERE c.IDcargoM =p.IDcargoM
						and c.nombre=?
                        GROUP BY c.IDcargoM
                       ORDER BY c.IDcargoM");
	 $count->bindParam(1,$nombre);				   
	 $count->execute();
	 $cantidad=$count->fetch();
	?>
       <tr> 
       <th colspan="1"><b>Cantidad de trabajadores:   <?php echo $cantidad[0];?></b></th>
  
       </tr>
       </table>
    <?php
	}
	else{
		echo "Este cargo de mano de obra todavia no tiene trabajadores activos";
		}
?>
</html>