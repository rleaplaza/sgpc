<?php
session_start();
session_destroy();
session_unset();
?>
<?php
include("../db/connect.php");
try{
	$idsession=$_GET["id"];
	$sql=$dbh->prepare("update sesion set fecFin=curdate(),hraFin=curtime() where IDsession=?");
	$sql->bindParam(1,$idsession);
	$sql->execute();
	}catch(PDOException $e){
		echo("Error inesperado".$e->getMessage());
		}
header("location:../index.php");
?>