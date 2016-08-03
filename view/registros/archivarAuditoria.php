<?php session_start();?>
<?php
#Este programa se encarga de archivar registros del log de auditoría para reducir el tiempo de procesamiento de los registros, esta información archivada se registrara en una tabla histórica
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	if(isset($_POST["Fecha1"]) && isset($_POST["Fecha2"])){
		try{
			$fecha1=$_POST["Fecha1"];
			$fecha2=$_POST["Fecha2"];
			$sql=$dbh->prepare("Call sp_archivado(?,?)");
			$sql->bindParam(1,$fecha1);
			$sql->bindParam(2,$fecha2);
			$sql->execute();
			if($sql->rowCount()){
				foreach($sql->fetchAll() as $row){
					#asignacion de variables correspondientes a los registros del arreglo
					$identificador=$row["Identificador"];
					$userId=$row["USR_UID"];
					$username=$row["username"];
					$rol=$row["rol_usuario"];
					$fecha=$row["fecha_ingreso"];
					$hora=$row["hra_ingreso"];
					$ip=$row["IPterminal"];
					$menu=$row["Menu"];
					$submenu=$row["Submenu"];
					$opcion=$row["Opcion"];
					$browser=$row["navegador_web"];
					#sentencia sql para registrar la informacion historica dentro del arreglo
					$insert=$dbh->prepare("insert into auditoria_historico values(?,?,?,?,?,?,?,?,?,?,?)");
					$insert->bindParam(1,$identificador);
					$insert->bindParam(2,$userId);
					$insert->bindParam(3,$username);
					$insert->bindParam(4,$rol);
					$insert->bindParam(5,$fecha);
					$insert->bindParam(6,$hora);
					$insert->bindParam(7,$ip);
					$insert->bindParam(8,$menu);
					$insert->bindParam(9,$submenu);
					$insert->bindParam(10,$opcion);
					$insert->bindParam(11,$browser);
					$insert->execute();
					#borrado del registro
					$delete=$dbh->prepare("delete from auditoria where fecha_ingreso between ? and ?");
					$delete->bindParam(1,$fecha1);
					$delete->bindParam(2,$fecha2);
					$delete->execute();
					}
					#consulta de confirmacion
					$consulta=$dbh->prepare("select *from auditoria_historico where fecha_ingreso between ? and ?");
					$consulta->bindParam(1,$fecha1);
					$consulta->bindParam(2,$fecha2);
					$consulta->execute();
					if($consulta->rowCount()>0){
						echo "Datos archivados";
						?>
                        <img src="yes.jpg" height="20" width="20">
                        <?php
						}
				}else{
					echo "No se encontraron resultados";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
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