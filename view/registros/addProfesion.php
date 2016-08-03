<?php
session_start();//inicio de sesion
?>
<?php
#este programa se encarga de regsitrar las profesiones
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	require_once("genera.php");//llama al archivo de generacion de identificador
	if(isset($_POST["profesion"]) && $_POST["desc"]){
		$IDprofesion=generaCodigo();
	$profesion=trim($_POST["profesion"]);
	$desc=trim($_POST["desc"]);
	$insertProfesion=insertaProfesion($IDprofesion,$profesion,$desc);//funcion parar enviar al registro de profesiones
	}
}
else{
	header("location: ../../index.php");//dirige al login
	}
	
function insertaProfesion($idprof,$prof,$desc){//funcion para registrar la profesion
	global $dbh;//variable que instancia a la clase PDO para conectar a la base de datos
	#consulta de insercion de profesiones
	$sql=$dbh->prepare("insert into profesion values(?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idprof);//enlaza al id de la profesion
	$sql->bindParam(2,$prof);//enlaza al nombre de profesion
	$sql->bindParam(3,$desc);//enlaza a la descripcion
	$sql->execute();//ejecuta la instruccion
	}
?>