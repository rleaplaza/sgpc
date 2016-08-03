<?php session_start();//funcion de inicio de sesion?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){//verifica si existen la sesi
	if(isset($_POST["idproveedor"])){//verifica la existencia del id del proveedor
	require_once("../../db/connect.php");//llama a la conexion a base de datos
	require_once("genera.php");//llama al archivo de generacion de identificadores
	try{
		$idMaterial=generaCodigo();//funcion para general el identificador
		$idprov=$_POST["idproveedor"];//captura el id de proveedor
		$desc=trim($_POST["desc"]);//captura la descripcion
		$unidad=trim(strtoupper($_POST["unidad"]));
		$precio=trim($_POST["precio"]);
		#consulta de verificacion
		$sql=$dbh->prepare("select *from material where descripcion=? and IDproveedor=?");
		$sql->bindParam(1,$desc);
		$sql->bindParam(2,$idprov);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Material registrado por proveedor";
			}else{
		#envia los parametros a la funcion de registro
		$insert=insertMaquinaria($idMaterial,$idprov,$desc,$unidad,$precio);
			}
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
#funcion de registro en base a los parametros
function insertMaquinaria($IDmat,$IDprov,$descrip,$unit,$price){
	global $dbh;
	#consulta de registro de materiales
	$sql=$dbh->prepare("insert into material values(?,?,?,?,?,0,curdate(),curtime())");
	$sql->bindParam(1,$IDmat);
	$sql->bindParam(2,$IDprov);
	$sql->bindParam(3,$descrip);
	$sql->bindParam(4,$unit);
	$sql->bindParam(5,$price);
	if($sql->execute()){
		echo "Material registrado";
		}else{
			echo "No se pudo registrar el material";
			}
	}

?>