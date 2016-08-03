<?php
session_start();
?>
<?php
if(isset($_POST["idpagina"])){
	try{ require_once("../../db/connect.php");
		$idpagina=$_POST["idpagina"];
		$subpermiso=strtoupper(trim($_POST["subpermiso"]));
		$desc=trim($_POST["desc"]);
		$editSubMenu=editOpcion($idpagina,$subpermiso,$desc);
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
function editOpcion($IDpagina,$subpagina,$description){
	global $dbh;
	$sql=$dbh->prepare("update pagina_opcion set nombre=?, descripcion=? where IDpagina=?");
	$sql->bindParam(1,$subpagina);
	$sql->bindParam(2,$description);
	$sql->bindParam(3,$IDpagina);
	$sql->execute();
	
	return $sql;
	}
?>