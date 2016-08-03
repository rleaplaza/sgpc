<?php
session_start();
?>
<?php
if(isset($_POST["idopcion"])){
	try{ require_once("../../db/connect.php");
		$idopcion=$_POST["idopcion"];
		$opcion=strtoupper(trim($_POST["opcion"]));
		$desc=trim($_POST["desc"]);
		$editSubMenu=editOpcion($idopcion,$opcion,$desc);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editOpcion($IDopcion,$opt,$description){
	global $dbh;
	$sql=$dbh->prepare("update opcion set nombreOpcion=?, descripcion=? where IDopcion=?");
	$sql->bindParam(1,$opt);
	$sql->bindParam(2,$description);
	$sql->bindParam(3,$IDopcion);
	$sql->execute();
	
	return $sql;
	}
?>