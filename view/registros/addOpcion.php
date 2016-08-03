<?php
session_start();//inicio de la sesion
?>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesion
	require_once("../../db/connect.php");//llama a la conexion
	if(isset($_POST["idsubmenu"])){//captura el id de submenu
    $idsubmenu=$_POST["idsubmenu"];//almacena el id de submenu
	$nombreopcion=strtoupper(trim($_POST["opcion"]));
	$desc=trim($_POST["desc"]);
	$dir=trim($_POST["direccion"]);
	$insertModulo=insertaOpcion($idsubmenu,$nombreopcion,$desc,$dir);//funcion que envia a los parametros
	}
}
else{
	header("location: ../../index.php");
	}
	
function insertaOpcion($idsubmod,$opcion,$descripcion,$direccion){
	global $dbh;//variable de conexion a base de datos
	$sql=$dbh->prepare("insert into opcion values('null',?,?,?,?,'activo',curdate(),curtime())");
	$sql->bindParam(1,$idsubmod);
	$sql->bindParam(2,$opcion);
	$sql->bindParam(3,$descripcion);
	$sql->bindParam(4,$direccion);
	$sql->execute();
	}
?>