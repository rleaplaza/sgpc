<?php session_start();//inicio de sesión
?>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	if(isset($_POST["userid"])){
	$userid=$_POST["userid"];
	echo $userid;
	$nombre=trim(ucwords(strtolower($_POST["nombre"])));
	$app=trim(ucwords(strtolower($_POST["app"])));
	$apm=trim(ucwords(strtolower($_POST["apm"])));
	$ci=trim($_POST["ci"]);
	$empresa=trim($_POST["empresa"]);
	$dir=trim($_POST["dir"]);
	$tel=trim($_POST["tel"]);
	$insertCargo=insertaEncargado($userid,$nombre,$app,$apm,$ci,$empresa,$dir,$tel);
	}else{
		header("location: ../../index.php");
		}
}
else{
	header("location: ../../index.php");
	}
	
function insertaEncargado($UserID,$nomb,$paterno,$materno,$cedula,$empr,$direccion,$telefono){
	global $dbh;
	$sql=$dbh->prepare("insert into encargadomanoobra values(?,?,?,?,?,?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$UserID);
	$sql->bindParam(2,$nomb);
	$sql->bindParam(3,$paterno);
	$sql->bindParam(4,$materno);
	$sql->bindParam(5,$cedula);
	$sql->bindParam(6,$empr);
	$sql->bindParam(7,$direccion);
	$sql->bindParam(8,$telefono);
	if($sql->execute()){
		echo "registro realizado";
		}else{
			echo "Error en el registro";
			}
	}
?>