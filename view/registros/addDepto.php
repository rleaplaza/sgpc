<?php session_start();//función de inicio de sesión
?>
<?php
#Este programa se encarga de registrar departamentos
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("genera.php");//genera el id del departamento
	if(isset($_POST["depto"]) && $_POST["descdepto"]){//verifica que los campos depto y descripción existan
		$IDdepto=generaCodigo();//función para generar el id del dpto
	$depto=strtoupper(trim($_POST["depto"]));//captura el departamento eliminando espacios 
	$descdepto=trim($_POST["descdepto"]);//captura de la descripción
	$insertDepto=insertaDepto($IDdepto,$depto,$descdepto);//función para insertar el departamento
	echo $depto ." ". $descdepto. " " .$IDdepto;
	}
}
else{
	header("location: ../../index.php");//redirige al login
	}
	
function insertaDepto($iddept,$dept,$desc){//función para registrar el departamento
	global $dbh;
	#consulta de registro de departamento
	$sql=$dbh->prepare("insert into departamento values(?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$iddept);
	$sql->bindParam(2,$dept);
	$sql->bindParam(3,$desc);
	$sql->execute();
	}
?>