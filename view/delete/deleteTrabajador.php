<?php
session_start();//función de inicio de sesión
?>
<html>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproy"])){
		require_once("../../db/connect.php");
		try{
		$idproy=$_POST["IDproy"];
		$idtrabajador=$_POST["codTrabajador"];
		$idcargo=$_POST["IDcargo"];
		$sql=$dbh->prepare("select *from participa where IDproyecto=? and CI_trabajador=?");
		$sql->bindParam(1,$idproy);
		$sql->bindParam(2,$idtrabajador);
		$sql->execute();
		if($sql->rowCount()>0){
			//borra al trabajador de la tabla de participantes
		$delete=$dbh->prepare("delete from participa where IDproyecto=? and CI_trabajador=?");
		$delete->bindParam(1,$idproy);
		$delete->bindParam(2,$idtrabajador);
		//reducción de la cantidad de trabajadores incorporados
		$reduce=$dbh->prepare("update solicita set cantidad_contratada=cantidad_contratada-1, estado='Pendiente' where IDproyecto=? and IDcargo_M=?");
		$reduce->bindParam(1,$idproy);
		$reduce->bindParam(2,$idcargo);
		if($delete->execute() && $reduce->execute()){
			echo "Trabajador eliminado";
			}else{
			echo "No se pudo eliminar el registro";	
				}		
			}else{
				echo "Ningún registro para eliminar";
				}
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>

</html>