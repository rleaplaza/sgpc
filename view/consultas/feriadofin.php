<?php
sleep(1);
require_once("../../db/connect.php");//llama a la conexion a base de datos
try{
if(isset($_REQUEST)) {
	$feriado=trim($_REQUEST["fec2"]);//captura la fecha de inicio
	$query =$dbh->prepare("select * from calendario_feriado where Inicio_feriado = ? or Fin_feriado=?");
		$query->bindParam(1,$feriado);//enlaza al dia del calendario
	$query->bindParam(2,$feriado);//enlaza al dia del calendario
	$query->execute();
	
	if($query->rowCount() > 0)
		echo '<div id="Error">Dia correspondiente a feriado</div>';
	else
		echo '<div id="Success">Dia disponible</div>';
}
}catch(PDOException $e){
	echo("Error inesperado".$e->getMessage());
	}
?>