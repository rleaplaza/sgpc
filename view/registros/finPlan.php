<?php session_start();//función de inico de sesión?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproyecto"])){
		require_once("../../db/connect.php");
		$IDplan=$_POST["IDplan"];
		$IDproyecto=$_POST["IDproyecto"];
		$sql=$dbh->prepare("update planificacion set fecFin=curdate() where IDplanificacion=? and IDproyecto=?");
		$sql->bindParam(1,$IDplan);
		$sql->bindParam(2,$IDproyecto);
		if($sql->execute()){
			echo "Planificacón finalizada";
			}else{
				echo "No se pudo finalizar la planificación";
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>