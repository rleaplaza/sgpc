<?php session_start();//inicio de sesion?>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	require_once("../../db/connect.php");
	require_once("genera.php");//genera el identificador
	if(isset($_POST["userid"])){//captura el user id
    $idprov=generaCodigo();//genera el identificador
	$userid=$_POST["userid"];
	echo $userid;//imprime el id de usuario
	$nombre=trim(ucwords(strtolower($_POST["nombre"])));//captura el nombre del proveedor
	$app=trim(ucwords(strtolower($_POST["app"])));//captura el apellido parterno
	$apm=trim(ucwords(strtolower($_POST["apm"])));//captura el apellido materno
	$ci=trim($_POST["ci"]);//captura la cedula de identidad
	$empresa=trim($_POST["empresa"]);//captura el nombre de la empresa
	$dir=trim($_POST["dir"]);//captuar la direcion
	$tel=trim($_POST["tel"]);//captura el telefono
	//envia a la funcion de insercion
	$insertProveedor=insertaProveedor($idprov,$userid,$nombre,$app,$apm,$ci,$empresa,$dir,$tel);
	}else{
		header("location: ../../index.php");
		}
}
else{
	header("location: ../../index.php");//redirige al login
	}
	#funcion de insercion de proveedores
function insertaProveedor($idProv,$UserID,$nomb,$paterno,$materno,$cedula,$empr,$direccion,$telefono){
	global $dbh;//variable que instancia a la clase PDO
	$sql=$dbh->prepare("insert into proveedor values(?,?,?,?,?,?,?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idProv);
	$sql->bindParam(2,$UserID);
	$sql->bindParam(3,$nomb);
	$sql->bindParam(4,$paterno);
	$sql->bindParam(5,$materno);
	$sql->bindParam(6,$cedula);
	$sql->bindParam(7,$empr);
	$sql->bindParam(8,$direccion);
	$sql->bindParam(9,$telefono);
	if($sql->execute()){
		echo "registro realizado";
		}else{
			echo "Error en el registro";
			}
	}
?>