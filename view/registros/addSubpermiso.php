<?php
session_start();//inicio de sesion
?>
<?php
if(isset($_SESSION["username"])){//verifica la exitencia de la sesion
	require_once("../../db/connect.php");//llamada a la conexion a base de datos
	if(isset($_POST["idopcion"])){//verifica la existencia de la opcion
    $idopcion=$_POST["idopcion"];//captura la opcion
	$nombresubpermiso=strtoupper(trim($_POST["subpermiso"]));//captura el nombre del subpermiso
	$desc=trim($_POST["desc"]);//captura la descripcion
	$dir=trim($_POST["direccion"]);//captura la direccion
	$insertModulo=insertaOpcion($idopcion,$nombresubpermiso,$desc,$dir);
	}
}
else{
	header("location: ../../index.php");
	}
	#funcion para registrar el subpermiso
function insertaOpcion($idopt,$subpermiso,$descripcion,$direccion){
	global $dbh;
	$sql=$dbh->prepare("insert into pagina_opcion values('null',?,?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idopt);
	$sql->bindParam(2,$subpermiso);
	$sql->bindParam(3,$descripcion);
	$sql->bindParam(4,$direccion);
	$sql->execute();
	}
?>