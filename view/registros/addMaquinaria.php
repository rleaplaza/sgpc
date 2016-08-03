<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar el equipamiento dentro del sistema
if(isset($_SESSION["username"])){//verifica que la sesión exista
	if(isset($_POST["idproveedor"])){//verifica la existencia del id del proveedor
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("genera.php");//llama al archivo para general el identificador
	try{
		$idMaq=generaCodigo();//genera el identificador
		$idprov=trim($_POST["idproveedor"]);//captura el id del proveedor
		$desc=trim($_POST["desc"]);//captura la descripción
		$unidad=trim($_POST["unidad"]);//captura la unidad
		$marca=trim($_POST["marca"]);//captura la marca
		$modelo=trim($_POST["modelo"]);//captura el modelo
		$placa=trim(strtoupper($_POST["placa"]));//captura el nro de placa
		$potencia=trim($_POST["potencia"]);//captura el campo potencia
		$precio=trim($_POST["precio"]);//captura el precio
		#envía los parámetros a la función para registrar el registro
		$insert=insertMaquinaria($idMaq,$idprov,$desc,$unidad,$marca,$modelo,$placa,$potencia,$precio);	
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("header: ../../index.php");//redirige al login
			}
	}else{
		header("header: ../../index.php");//redirige al login
		}
?>

<?php
#función para registrar el equipamiento en base a la captura de los parámetros
function insertMaquinaria($IDmaq,$IDprov,$descrip,$unit,$Marca,$mod,$pl,$hp,$price){
	global $dbh;//variable que instancia a la clase PDO para conecar a la base de datos
	#consulta de registro de equipamiento
	$sql=$dbh->prepare("insert into maquinaria values(?,?,?,?,?,?,?,?,?,0,curdate(),curtime())");
	$sql->bindParam(1,$IDmaq);
	$sql->bindParam(2,$IDprov);
	$sql->bindParam(3,$descrip);
	$sql->bindParam(4,$unit);
	$sql->bindParam(5,$Marca);
	$sql->bindParam(6,$mod);
	$sql->bindParam(7,$pl);
	$sql->bindParam(8,$hp);
	$sql->bindParam(9,$price);
	if($sql->execute()){
		echo "Equipo registrado";
		}else{
			echo "No se pudo registrar el equipo";
			}
	}

?>
