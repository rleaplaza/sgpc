<?php
session_start();//función de inicio de sesión
?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("generaNumero.php");//genera el identificador
	if(isset($_POST["IDproyecto"])){//verifica si existe el id del proyecto
	$idfase=generaNumero();//genera el nro de fase
	$idproyecto=$_POST["IDproyecto"];//captura el id del proyecto
	$idplan=$_POST["IDplan"];//captura el id de planificación
	$fase=$_POST["Fase"];//captura la fase
	$long=$_POST["Long"];//captura la longitud de la fase en caso de ser tramo
	$estado="en ejecucion";
	$consulta=$dbh->prepare("select *from fase where IDproyecto=? and nombre=?");
	$consulta->bindParam(1,$idproyecto);
	$consulta->bindParam(2,$fase);
	$consulta->execute();
	if($consulta->rowCount()>0){
		echo "Fase registrada en sistema";
	}
	else{
	if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$long))){
		echo "El valor de la longitud es numérico";
	}else{
	$insert=insertaFase($idfase,$idproyecto,$idplan,$fase,$long,$estado);//función para registrar la fase
	}
	}
	}else{
		header("location:../../index.php");//redirige al login
		}
}else{
		header("location: ../../index.php");//redirige al login
		}
?>

<?php
#función para registrar la fase
function insertaFase($IDfase,$idproy,$IDplan,$stage,$longitud,$est){
	global $dbh;
	#consulta de registro de la fase
	$sql=$dbh->prepare("insert into fase values(?,?,?,?,?,?,0,0,curdate(),curtime())");
	$sql->bindParam(1,$IDfase);//enlace al id de fase
	$sql->bindParam(2,$idproy);//enlace al id del proyecto
	$sql->bindParam(3,$IDplan);//enlace al id de planificación
	$sql->bindParam(4,$stage);//enlace a la fase
	$sql->bindParam(5,$longitud);//enlace a la longitud
	$sql->bindParam(6,$est);//enlaza al estado de la fase
	if($sql->execute()){
		echo "Registro de fase realizado";//mensaje de confirmación
		?>
        <img src="yes.jpg" height="25" width="25">
        <?php
		}else{
		echo "No se pudo registrar la fase";
		?>
        <img src="no.jpg" height="25" width="25">
        <?php	
			}
	}
?>