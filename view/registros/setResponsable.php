<?php
session_start();
?>

<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	require_once("genera.php");
	try{
		sleep(1);
		$idresp=generaCodigo();
		$ci=$_POST["ciEmp"];
		$proy=$_POST["nombProyecto"];
		//consulta para recuperar el ID del proyecto según su nombre
		$consulta=$dbh->prepare("select IDproyecto from proyecto where nombre=?");
		$consulta->bindParam(1,$proy);
		$consulta->execute();
		$fila=$consulta->fetch();
		$idproyecto=$fila["IDproyecto"];
		//consulta si la asignación existe
		$sql=$dbh->prepare("select *from empleado as e, personaltecnico as pt, responsable_de as r, proyecto as p
		                    WHERE e.CI=pt.CI 
							and pt.CI=r.CI_responsable
							and r.IDproyecto=p.IDproyecto
							and p.IDproyecto=?
							and pt.CI=?");
		$sql->bindParam(1,$idproyecto);
		$sql->bindParam(2,$ci);
		$sql->execute();
		if($sql->rowCount()>0){
			$row=$sql->fetch();
			echo "Empleado: " .$row["nombres"]. " ".$row["app"]. " ya asignado como responsable";
			}else{
			$insert=$dbh->prepare("insert into responsable_de values(?,?,?,curdate(),curtime())");
			$insert->bindParam(1,$idresp);
			$insert->bindParam(2,$idproyecto);
			$insert->bindParam(3,$ci);
			if($insert->execute()){
				$aux=$dbh->prepare("select *from empleado as e, personaltecnico as pt, responsable_de as r, proyecto as p
		                    WHERE e.CI=pt.CI 
							and pt.CI=r.CI_responsable
							and r.IDproyecto=p.IDproyecto
							and p.IDproyecto=?
							and pt.CI=?");
				$aux->bindParam(1,$idproyecto);
				$aux->bindParam(2,$ci);
				if($aux->execute()){
				$result=$aux->fetch();
				?>
                <table>
                <tr><td>Nombre de responsable:</td><td><?php echo $result["nombres"]." ".$result["app"];?></td></tr>
                <tr><td>Fecha de asignación</td><td><?php echo $result["fecAsignacion"];?></td></tr>
                <tr><td>Hora de asignación</td><td><?php echo $result["hraAsignacion"];?></td></tr>
                </table>
                <?php
				}else{
					echo "No se ha podido asignar al responsable";
					}
				}	
				}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	
	}else{
		header("location: ../../index.php");
		}
?>