<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
try{
require_once("../../db/connect.php");
$opcion=$_POST["codOpcion"];
$userId=$_POST["IDusuario"];
$consulta=$dbh->prepare("Select *from permiso where IDopcion=? and USR_UID=?");
$consulta->bindParam(1,$opcion);
$consulta->bindParam(2,$userId);
$consulta->execute();
if($consulta->rowCount()>0){
	$sql=$dbh->prepare("delete from permiso where IDopcion=? and USR_UID=?");
	$sql->bindParam(1,$opcion);
	$sql->bindParam(2,$userId);
	$sql->execute();
	if($sql){
		echo("Permiso eliminado");?><img src="no.jpg" width="15" height="15"  alt=""/>
        <?php
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