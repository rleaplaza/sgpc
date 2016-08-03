<?php session_start();//función de inicio de sesión?>
<?php
#Este programa se encarga de registrar cargos de mano de obra
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("genera.php");//archivo que genera identificadores
	if(isset($_POST["nombre"]) && $_POST["desc"]){
		$IDcargoM=generaCodigo();//función para generar el código del cargo de mano de obra
	$nombre=trim(ucwords(strtolower($_POST["nombre"])));//captura el nombre
	$desc=trim($_POST["desc"]);//captura la descripción
	$unidad=trim($_POST["unidad"]);//captura la unidad
	$precio=trim($_POST["precio"]);//captura el precio
	#función para insertar el cargo
	$insertCargoM=insertaCargoM($IDcargoM,$nombre,$desc,$unidad,$precio);//
	}
}
else{
	header("location: ../../index.php");//redirige al login
	}
	#función para registrar el cargo mediante los parámetros enviados
function insertaCargoM($idcargom,$nomb,$descripcion,$unit,$prec){
	global $dbh;
	$cantidad=0;//variable cantidad que por defecto es 0
	#consulta de registro mediante los parámetros y variables definidas
	$sql=$dbh->prepare("insert into cargomanodeobra(IDcargoM,nombre,descripcion,unidadTrabajo,cantidad,precioUnitario, fecCreacion, hraCreacion) values(?,?,?,?,?,?,curdate(),curtime())");
	$sql->bindParam(1,$idcargom);
	#enlaza los parámetros en base a los signos de interrogación
	$sql->bindParam(2,$nomb);
	$sql->bindParam(3,$descripcion);
	$sql->bindParam(4,$unit);
	$sql->bindParam(5,$cantidad);
	$sql->bindParam(6,$prec);
	if($sql->execute()){
		echo "registro realizado";
		}else{
			
			echo "error en el registro";
			}
	}
?>