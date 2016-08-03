<?php
function userProperties($userid, $pass){//funcion para cambiar el password del usuario
	include("../../db/connect.php");
	try{
		$pass=trim(sha1($pass));//captura el password eliminando espacios
	global $dbh;//variable de instancia a la clase PDO
	$sql=$dbh->prepare("insert into historico_password values(?,curdate(),?)");
	$sql->bindParam(1,$userid);
	$sql->bindParam(2,$pass);
	$sql->execute();
	}catch(PDOException $e){
		echo("Error inesperado".$e->getMessage());
		}
	}
?>