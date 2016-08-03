<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	try{
		$idproy=$_POST["codProy"];
		$sql=$dbh->prepare("SELECT e.nombres, app, apm, fechaAsignacion, hraAsignacion FROM empleado AS e, personaltecnico AS pt, proyecto AS p
                            WHERE e.IDempleado = pt.IDempleado
                            AND pt.IDproyecto = p.IDproyecto
							and p.IDproyecto=?");
		$sql->bindParam(1,$idproy);
		$sql->execute();
		if($sql->rowCount()>0){
			?>
            <table>
            <th>Nombre de empleado</th>
            <th>Fecha de asignación</th>
            <th>Hora de asignación</th>
            <?php
			foreach($sql->fetchAll() as $row){
				?>
            <tr><td><?php echo $row[0]." ".$row[1]." ".$row[2];?></td>
                <td><?php echo $row[4];?></td>
                <td><?php echo $row[5];?></td></tr>
                <?php
				}
			?>
            </table>
            <?php
			}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
?>