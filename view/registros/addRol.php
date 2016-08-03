<?php session_start();//inicio de sesion?>
<?php
#Este prograam se encarga de registrar roles del sistema
if(isset($_SESSION["username"])){//verifica la existencia de sesion
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	if(isset($_POST["idrol"]) && $_POST["rol"]){
	$IDrol=strtoupper(trim($_POST["idrol"]));//convierte a mayusculas
	$rol=trim($_POST["rol"]);
	$desc=trim($_POST["desc"]);
	$insert=insertaRol($IDrol,$rol,$desc);//envia a la funcion de registro de roels
	
	}
}
else{
	header("location: ../../index.php");//redirige al login
	}
	#funcion para registrar el rol
function insertaRol($idrol,$nombRol,$descripcion){
	global $dbh;//variable que instancia a la clase PDO
	$sql=$dbh->prepare("insert into rol values(?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idrol);
	$sql->bindParam(2,$nombRol);
	$sql->bindParam(3,$descripcion);
	$sql->execute();//ejecuta la instruccion
	return $sql;//devuelve la instruccion
	}
?>