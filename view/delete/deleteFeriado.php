<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDferiado"])){
		require_once("../../db/connect.php");
		try{
			$idferiado=$_POST["IDferiado"];
			$sql=$dbh->prepare("delete from calendario_feriado where IDferiado=?");
			$sql->bindParam(1,$idferiado);
			if($sql->execute()){
				echo "Registro eliminado";
				}else{
				echo "No se pudo eliminar el registro";	
					}
			
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			echo "Ningun registro a eliminar";
			}
	}else{
		header("location: ../../index.php");
		}
?>