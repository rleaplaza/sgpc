<?php session_start();?>
<html>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	require_once("genera.php");
	if(isset($_POST["codproyecto"])){
	$idsolicitud=generaCodigo();
	$idproyecto=$_POST["codproyecto"];
	$ci=$_POST["cedula"];
	$cargo=$_POST["Cmanoobra"];
	$cant_sol=intval($_POST["Cant"]);
	$cant_contrat=0;
	$estado="Pendiente";
	//extraer el id del empleado técnico
	$sql=$dbh->prepare("select IDpersonalTecnico from personaltecnico where CI=?");
	$sql->bindParam(1,$ci);
	$sql->execute();
	$fila=$sql->fetch();
	$idpt=$fila["IDpersonalTecnico"];
	//consultar si la solicitud ya se ha realizado
	
	$solicitud=$dbh->prepare("select *from solicita where IDcargo_M=?");
	$solicitud->bindParam(1,$cargo);
	$solicitud->execute();
	// validar el numero entero
	if(!(is_numeric($cant_sol)) || $cant_sol==null){
		echo "El valor de la cantidad debe ser numérico";
		?>
         <img src="no.jpg" height="25" width="25">
        <?php
		}else{
		
		$insertSol=$dbh->prepare("insert into solicita values(?,null,?,?,?,?,?,?,curdate(),curtime())");
		$insertSol->bindParam(1,$idsolicitud);
		$insertSol->bindParam(2,$idproyecto);
		$insertSol->bindParam(3,$idpt);
		$insertSol->bindParam(4,$cargo);
		$insertSol->bindParam(5,$cant_sol);
		$insertSol->bindParam(6,$cant_contrat);
		$insertSol->bindParam(7,$estado);
		if($insertSol->execute()){
			echo "Solicitud registrada";
			?>
         <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
			echo "No se pudo registrar la solicitud";
			?>	
             <img src="no.jpg" height="25" width="25">
		  <?php
          }			
			}
		
	}else{
		header("location: ../../index.php");//redirige al login
		}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>
</html>