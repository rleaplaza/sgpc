<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["codproyecto"])){
		require_once("../../db/connect.php");
		require_once("genera.php");
		try{
			$idsolicitud=generaCodigo();
			$idproyecto=$_POST["codproyecto"];
			$ci=$_POST["cedula"];
			$idmaquinaria=$_POST["Maquinaria"];
			$cant_sol=$_POST["Cant"];
			$estado="Pendiente";
			$sql=$dbh->prepare("select IDempleado from empleado where CI=?");
	        $sql->bindParam(1,$ci);
	        $sql->execute();
	        $fila=$sql->fetch();
	        $idempleado=$fila["IDempleado"];
			if((preg_match('/^[0-9]+(\.[0-9]+)?$/',$cant_sol))){
			
					if(!(is_numeric($cant_sol)) || $cant_sol==null){
					echo "El valor de la cantidad debe ser numérico";
					}else{
$insert=$dbh->prepare("INSERT INTO solicitud_maquinaria VALUES (?, ?, null, ?, ?, curdate() , ?,NULL , NULL , NULL , ?, NULL , NULL)");

$insert->bindParam(1,$idsolicitud);
$insert->bindParam(2,$idproyecto);
$insert->bindParam(3,$idmaquinaria);
$insert->bindParam(4,$idempleado);
$insert->bindParam(5,$cant_sol);
$insert->bindParam(6,$estado);
if($insert->execute()){
	echo "Solicitud registrada";
	?>
    <img src="yes.jpg" width="25" height="25">
    <?php
	}else{
		echo "No se pudo guardar la solicitud";
		}
						}
			}else{
				echo "El valor de la cantidad debe ser numérico";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
			}catch(PDOException $e){
			echo "Error inesperado";
			}	
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>