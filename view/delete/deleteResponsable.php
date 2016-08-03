<?php session_start();?>
<?php 
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	$ci=$_POST["ciEmp"];
	$nombProy=$_POST["nombProyecto"];
	$sql=$dbh->prepare("select IDproyecto from proyecto where nombre=?");
	$sql->bindParam(1,$nombProy);
	$sql->execute();
	$row=$sql->fetch();
	$idproy=$row["IDproyecto"];
	
	$delete=$dbh->prepare("delete from responsable_de where IDproyecto=? and CI_responsable=?");
	$delete->bindParam(1,$idproy);
	$delete->bindParam(2,$ci);
	if($delete->execute()){
		echo "Asignacion eliminada";
		}else{
			echo "Error en la eliminacion";
			}
	
	}else{
		header("../../index.php");
		}
?>