<meta charset="utf-8">
<?php
sleep(1);
require_once("../../db/connect.php");
try{
if(isset($_REQUEST)) {
	$param=trim($_REQUEST["nombre"]);
	$query =$dbh->prepare("select * from parametro where nombre = ?");
	$query->bindParam(1,$param);
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Parámetro ya existente</div>';
	else
		echo '<div id="Success">Parámetro Disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>