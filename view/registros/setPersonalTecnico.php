<?php session_start();?><head><meta charset="utf-8">
<style>
label{ font:Verdana, Geneva, sans-serif;
		     color:#00C;
	         }
			 </style>
<?php
if(isset($_SESSION["username"])){
	try{
		require_once("../../db/connect.php");
		require_once("genera.php");
		sleep(1);
		//captura de variables
	$idasignacion=generaCodigo();
	$idempleado=$_POST["codEmp"];
	$idplan=$_POST["IDplan"];
	//captura de la cédula de identidad del empleado
	$query=$dbh->prepare("select nombres, app, apm, CI from empleado where IDempleado=?");
	$query->bindParam(1,$idempleado);
	$query->execute();
	$fila=$query->fetch();
	$nombreEmpleado=$fila["nombres"]." ".$fila["app"]." ".$fila["apm"];
	$ci=$fila["CI"];
	
	//consulta para averiguar si el empleado a asignar ya se encuentra en personal técnico del proyecto en cuestión
	$idproy=$_POST["IDproyecto"];
	$sql=$dbh->prepare("select e.nombres, e.app, p.nombre from empleado as e, proyecto as p, personaltecnico as pt
	                    where e.IDempleado=pt.IDempleado
						and pt.IDproyecto=p.IDproyecto
						and p.IDproyecto=?
						and e.IDempleado=?");
	$sql->bindParam(1,$idproy);
	$sql->bindParam(2,$idempleado);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		echo "Empleado: <b>".$row["0"]." ".$row[1]."</b> ya asignado a proyecto";
		?>
        
<img src="yes.jpg" width="15" height="15"  alt=""/><br>
        <?php
			}else{
				$descPart="Personal tecnico participante en el proyecto";
	$insert=$dbh->prepare("insert into personaltecnico values(?,?,?,?,?,?,null,curdate(),curtime())");
	$insert->bindParam(1,$idasignacion);
	$insert->bindParam(2,$idempleado);
	$insert->bindParam(3,$idproy);
	$insert->bindParam(4,$idplan);
	$insert->bindParam(5,$ci);
	$insert->bindParam(6,$descPart);
	if($insert->execute()){
		$consulta=$dbh->prepare("select fechaDesignacion, hraDesignacion from personaltecnico 
		                         where IDproyecto=?
								 and IDempleado=?");
		$consulta->bindParam(1,$idproy);
		$consulta->bindParam(2,$idempleado);
		$consulta->execute();
		$result=$consulta->fetch();
		?>
        <table>
        <tr><td><label>Empleado:</label></td><td><?php echo $nombreEmpleado;?><td></tr>
        <tr><td><label>Fecha de asignación a proyecto:</label></td><td><?php echo $result["fechaDesignacion"];?></td></tr>
        <tr><td><label>Hora de asignación a proyecto:</label></td><td><?php echo $result["hraDesignacion"];?></td></tr>
        </table>
        <?php
		}else{
			echo "No se ha podido asignar el empleado al proyecto";
			}	
				}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
?>