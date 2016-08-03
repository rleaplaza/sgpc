<?php
session_start();
?>
<?php
if(isset($_POST["idrol"])){
	try{ require_once("../../db/connect.php");
		$idrol=$_POST["idrol"];
		$rol=$_POST["rol"];
		$desc=$_POST["desc"];
		$editRol=editRol($idrol,$rol,$desc);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editRol($IDrol,$role,$descripcion){
	global $dbh;
	$sql=$dbh->prepare("update rol set nombreRol=?, descripcion=? where IDrol=?");
	$sql->bindParam(1,$role);
	$sql->bindParam(2,$descripcion);
	$sql->bindParam(3,$IDrol);
	$sql->execute();
	
	return $sql;
	}
?>