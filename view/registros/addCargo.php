<?php
session_start();//inicia la sesión
?>
<?php
#Este programa se encarga de registrar los cargos existentes en la empresa
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("genera.php");//archivo que genera el identificador
	if(isset($_POST["cargo"]) && $_POST["desccargo"]){
		$IDcargo=generaCodigo();//función para generar el id del cargo
	$cargo=trim($_POST["cargo"]);//captura el nombre de cargo
	$desccargo=trim($_POST["desccargo"]);//captura la descripción
	$insertCargo=insertaCargo($IDcargo,$cargo,$desccargo);//llama a la función para registrar el cargo
	}
}
else{
	header("location: ../../index.php");//redirige al login
	}
	
function insertaCargo($idcargo,$carg,$desc){//función para el registro del cargo
	global $dbh;//variable de la conexión global
	#consulta de registro del cargo
	$sql=$dbh->prepare("insert into cargo values(?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idcargo);//enlaza al id de cargo
	$sql->bindParam(2,$carg);//enlaza al nombre del cargo
	$sql->bindParam(3,$desc);//enlaza a la descripción
	$sql->execute();//ejecuta la instrucción
	}
?>