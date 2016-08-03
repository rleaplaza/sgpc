<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$submenu=trim($_REQUEST["submenu"]);
	$query =$dbh->prepare("select * from submenu where nombreSubmenu = ?");
	$query->bindParam(1,$submenu);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">SubMenu ya existente</div>';
	else
		echo '<div id="Success">SubMenu Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>