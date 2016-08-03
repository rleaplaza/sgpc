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
			$idmaterial=$_POST["Material"];
			$cant_sol=$_POST["Cant"];
			$estado="Pendiente";
			$sql=$dbh->prepare("select IDpersonalTecnico from personaltecnico where CI=?");
	        $sql->bindParam(1,$ci);
	        $sql->execute();
	        $fila=$sql->fetch();
	        $idpt=$fila["IDpersonalTecnico"];
			$cant_incorp=0;
			
			$solicitud=$dbh->prepare("select *from solicitud_material where IDmaterial=?");
	        $solicitud->bindParam(1,$idmaterial);
	        $solicitud->execute();
			if($solicitud->rowCount()>0){
				echo "Su solicitud ya se encuentra en sistema";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}else{
					if(!(is_numeric($cant_sol)) || $cant_sol==null){
					echo "El valor de la cantidad debe ser numérico";
					}else{
//$insert=$dbh->prepare("INSERT INTO solicitud_material VALUES (?, ?, null, ?, ?, curdate() , ?, ?,NULL , NULL , NULL , ?)");
$insert=$dbh->prepare("INSERT INTO solicitud_material VALUES (?, ?, NULL , ?, ?, curdate() , ?, ?, NULL , NULL , NULL , ?)");
$insert->bindParam(1,$idsolicitud);
$insert->bindParam(2,$idproyecto);
$insert->bindParam(3,$idmaterial);
$insert->bindParam(4,$idpt);
$insert->bindParam(5,$cant_sol);
$insert->bindParam(6,$cant_incorp);
$insert->bindParam(7,$estado);
if($insert->execute()){
	echo "Solicitud registrada";
	?>
    <img src="yes.jpg" width="25" height="25">
    <?php
	}else{
		echo "No se pudo guardar la solicitud";
		}
						}
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