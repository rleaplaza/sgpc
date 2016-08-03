<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmat"])){
		require_once("../../db/connect.php");
		$idmaterial=$_POST["IDmat"];
		$nro=$_POST["numero"];
		$sql=$dbh->prepare("delete from detalle_solicitud_cotizacion where nro=? and IDmaterial=?");
		$sql->bindParam(1,$nro);
		$sql->bindParam(2,$idmaterial);
		if($sql->execute()){
			echo "Item eliminado de la solicitud";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo eliminar el item";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>