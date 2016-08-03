<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
try{
require_once("../../db/connect.php");
$opcion=$_POST["codOpcion"];
$idrol=$_POST["IDrol"];
$consulta=$dbh->prepare("Select *from rol_opcion where IDopcion=? and IDrol=?");
$consulta->bindParam(1,$opcion);
$consulta->bindParam(2,$idrol);
$consulta->execute();
if($consulta->rowCount()>0){
	$sql=$dbh->prepare("delete from rol_opcion where IDopcion=? and IDrol=?");
	$sql->bindParam(1,$opcion);
	$sql->bindParam(2,$idrol);
	$sql->execute();
	if($sql){
		echo("Permiso eliminado");?><img src="no.jpg" width="15" height="15"  alt=""/>
        <?php
	$delete=$dbh->prepare("delete from permiso where IDopcion=? and USR_UID!='00000000000000000000000000000001'");
	$delete->bindParam(1,$opcion);
	$delete->execute();
		}
	}
	else{
		echo("Permiso no asignado");?>
        <img src="no.jpg" width="15" height="15"  alt=""/><br>
        <?php
		}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
}
	else{header("location: ../../index.php");
		
		}

?>