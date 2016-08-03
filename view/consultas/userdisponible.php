<?php
sleep(1);
include("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$username =strtolower( $_REQUEST['username']);
	$query =$dbh->prepare("select * from usuario where username = ?");
	$query->bindParam(1,$username);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Usuario ya existente</div>';
	else
		echo '<div id="Success">Usuario Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>