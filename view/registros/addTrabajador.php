<?php
session_start();//inicia la sesion
?>
<?php
if(isset($_SESSION["username"])){//si existe la variable de sesion, continua con las siguientes instrucciones
	require_once("../../db/connect.php");
	//captura de variables del formulario
    if(isset($_POST["ci"])){
	$ci=$_POST["ci"];
    $CIenc=trim($_POST["ciencargado"]);
	$cargoM=$_POST["cargomanoobra"];
	$nombre=trim(ucwords(strtolower($_POST["nombre"])));
	$app=trim(ucwords(strtolower($_POST["app"])));
	$apm=trim(ucwords(strtolower($_POST["apm"])));
	$exp=$_POST["experiencia"];
	$tel=trim($_POST["tel"]);
	$dir=trim($_POST["dir"]);
	$fecn=trim($_POST["fecn"]);
	
	
	$insert=insertTrabajador($ci,$CIenc,$cargoM,$nombre,$app,$apm,$exp,$tel,$dir,$fecn);
	}else{
		header("location: ../../index.php");
		}
}
	else{
		header("location: ../../index.php");
		}
				
		
function insertTrabajador($cedula, $Ciencargado,$cargom,$nomb,$paterno,$materno,$expe,$telefono,$direccion,$fecNacimiento){
		global $dbh;
		$insert=$dbh->prepare("insert into personalmanoobra values(?,?,?,?,?,?,?,?,?,?,curdate(),curtime())");
		$insert->bindParam(1,$cedula);
		$insert->bindParam(2,$Ciencargado);
		$insert->bindParam(3,$cargom);
		$insert->bindParam(4,$nomb);
		$insert->bindParam(5,$paterno);
		$insert->bindParam(6,$materno);
		$insert->bindParam(7,$expe);
		$insert->bindParam(8,$telefono);
		$insert->bindParam(9,$direccion);
		$insert->bindParam(10,$fecNacimiento);
		if($insert->execute()){
			echo "Registro realizado";
			$query=$dbh->prepare("SELECT * FROM cargomanodeobra AS c, personalmanoobra AS p
                                  WHERE c.IDcargoM = p.IDcargoM
								  AND c.IDcargoM=?");
			$query->bindParam(1,$cargom);
			if($query->execute()){
			if($query->rowCount()>0){
				$updateCargo=$dbh->prepare("update cargomanodeobra set cantidad=cantidad+1 where IDcargoM=?");
				$updateCargo->bindParam(1,$cargom);
				$updateCargo->execute();
				}else{
					echo "no se pudo actualizar el cargo";
					}
			}else{
				echo "no se encontro ninguna fila";
				}
			}else{
				echo "Error al registrar trabajador";
				}
		}
			
?>