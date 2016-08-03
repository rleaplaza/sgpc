<?php
session_start();
?>
<?php
if(isset($_POST["idcargo"])){
	try{ require_once("../../db/connect.php");
		$idcargo=$_POST["idcargo"];
		$desc=$_POST["desccargo"];
		$editCargo=editCargo($idcargo,$desc);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editCargo($IDcargo,$descripcion){
	global $dbh;
	$sql=$dbh->prepare("update cargo set descripcion=? where IDcargo=?");
	$sql->bindParam(1,$descripcion);
	$sql->bindParam(2,$IDcargo);
	$sql->execute();
	
	return $sql;
	}
?>