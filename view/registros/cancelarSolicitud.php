<?php session_start();?>
<meta charset="utf-8">
<?php
require_once("../../db/connect.php");
try{
	if(isset($_SESSION["username"])){
	if(isset($_POST["NroSolicitud"])){
		$nroSolicitud=$_POST["NroSolicitud"];
		$consulta=$dbh->prepare("select *from solicitud_maquinaria where nro_solicitud=? and estado='Atendido'");
		$consulta->bindParam(1,$nroSolicitud);
		$consulta->execute();
		if($consulta->rowCount()==0){
		$sql=$dbh->prepare("update solicitud_maquinaria set estado='Cancelado' where nro_solicitud=?");
		$sql->bindParam(1,$nroSolicitud);
		if($sql->execute()){
			echo "Solicitud cancelada";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				echo "No se pudo realizar la operación";
				}
		}else{
			echo "La solicitud ya fue atendida";
			}
		}else{
			header("location: ../../index.php");
			}
		}else{
			header("location: ../../index.php");
			}
	}catch(PDOException $e){
		echo "Error inesperado:".$e->getMessage();
		}
?>