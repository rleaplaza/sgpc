<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$subpermiso=trim($_REQUEST["subpermiso"]);
	$query =$dbh->prepare("select * from pagina_opcion where nombre = ?");
	$query->bindParam(1,$subpermiso);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Subpermiso ya existente</div>';
	else
		echo '<div id="Success">Subpermiso Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>