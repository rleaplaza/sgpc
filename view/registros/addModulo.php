<?php session_start();//inicio de la sesion?>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	if(isset($_POST["modulo"]) && $_POST["descmodulo"]){
	$modulo=strtoupper(trim($_POST["modulo"]));
	$descmodulo=trim($_POST["descmodulo"]);
	$insertModulo=insertaModulo($modulo,$descmodulo);//envia a la funcion
	}
}
else{
	header("location: ../../index.php");
	}
	
function insertaModulo($mod,$desc){//funcion de registro de menus del sistema
	global $dbh;
	$sql=$dbh->prepare("insert into menu values('null',?,?,curdate(),curtime())");
	$sql->bindParam(1,$mod);
	$sql->bindParam(2,$desc);
	$sql->execute();
	}
?>