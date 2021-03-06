<?php session_start();?>
<!doctype html>
<html>
<meta charset="utf-8">
<style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }	
	</style>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
try{
	//consulta el carnet del usuario que realizó la solicitud
	$query=$dbh->prepare("SELECT nombres, app, apm, e.CI
                          FROM empleado AS e, usuario AS u
                          WHERE e.CI = u.CI
                          AND u.username = ?");
	$query->bindParam(1,$_SESSION["username"]);
	$query->execute();
	$fila=$query->fetch();
	$ci=$fila[3];
	$nombre=$fila[0]." ".$fila[1]." ". $fila[2];
	//consulta el proyecto
	$idproyecto=$_POST["codproyecto"];
	$sql=$dbh->prepare("SELECT s.nro_solicitud, p.nombre, m.descripcion, s.cantidad_sol, s.cant_incorp, s.estado,                        fecha
                       FROM personaltecnico AS pt, solicitud_material AS s, material AS m, proyecto AS p
                       WHERE pt.IDpersonalTecnico = s.IDpersonalTecnico
                       AND p.IDproyecto = s.IDproyecto
                       AND s.IDmaterial = m.IDmaterial
					   and pt.CI=?
					   and p.IDproyecto=?");
	$sql->bindParam(1,$ci);
	$sql->bindParam(2,$idproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		?>
        <label>Solicitante: <?php echo $nombre;?></label>
        <table>
        <th><label>Nro</label></th>
        <th><label>Material solicitado</label></th>
        <th><label>Cantidad solicitada</label></th>
        <th><label>Cantidad incorporada</label></th>
        <th><label>Estado actual</label></th>
        <th><label>Fecha de solicitud</label></th>
        <?php
		foreach($sql->fetchAll() as $row){
			?>
            <tr><td><?php echo $row[0];?></td>
            <td><?php echo $row[2];?></td>
            <td align="center"><?php echo $row[3];?></td>
            <td align="center"><?php echo $row[4];?></td>
            <td><?php echo $row[5];?></td>
            <td align="center"><?php echo $row[6];?></td></tr>
            <?php
			}
		}else{
			echo "Todavía no ha realizado ninguna solicitud";
			}
	
	}catch(PDOException $e){
		echo "Error inesperado";
		}
	}else{
		header("location: ../../index.php");
		}
?>

</html>