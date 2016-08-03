<?php 
session_start();
?>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	$idemp=$_POST["codEmp"];
	$idproy=$_POST["IDproyecto"];
	$delete=$dbh->prepare("delete from personaltecnico where IDempleado=? and IDproyecto=?");
	$delete->bindParam(1,$idemp);
	$delete->bindParam(2,$idproy);
	if($delete->execute()){
		echo "Asignacion eliminada";
		}else{
		echo "No se pudo eliminar la asignacion";	
			}
	}else{
		header("location: ../../index.php");
		}
?>