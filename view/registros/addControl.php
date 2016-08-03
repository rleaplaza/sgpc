<?php
session_start();
?>
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
		require_once("genera.php");
	if(isset($_POST["empId"])){
		$idreg=generaCodigo();
	     $empId=$_POST["empId"];
		 $motivo=$_POST["motivo"];
		 $obs=$_POST["obs"];
		 $desde=$_POST["desde"];
		 $hasta=$_POST["hasta"];
		 $idopcion=$_POST["idopcion"];
		 $inserta=addControl($idreg,$empId,$motivo,$obs,$desde,$hasta,$idopcion);
		 
			
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
		
			function addControl($reg,$uid, $mot, $observ,$from,$to,$opcion){
			global $dbh;
			//$tiempo=$from." to ".$to;
			$sql=$dbh->prepare("insert into controlpermiso values(?,?,curdate(),?,?,?,?,'vigente')");
			$sql->bindParam(1,$reg);
			$sql->bindParam(2,$uid);
			$sql->bindParam(3,$mot);
			$sql->bindParam(4,$observ);
			$sql->bindParam(5,$from);
			$sql->bindParam(6,$to);
			$sql->execute();
			return $opcion;
			}
?>