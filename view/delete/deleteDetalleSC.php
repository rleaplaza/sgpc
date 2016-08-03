<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");
		$nro=$_POST["Nro"];
		$idmaterial=$_POST["IDmaterial"];
		//consulta existencia de material en detalle de solicitud de cotización
		$sql=$dbh->prepare("select *from det_solicitud_cotizacion where nro_solicitud=? and IDmaterial=?");
		$sql->bindParam(1,$nro);
		$sql->bindParam(2,$idmaterial);
		$sql->execute();
		if($sql->rowCount()>0){
			$delete=$dbh->prepare("delete from det_solicitud_cotizacion where nro_solicitud=? and IDmaterial=?");
			$delete->bindParam(1,$nro);
		    $delete->bindParam(2,$idmaterial);
		    if($delete->execute()){
				echo "Item eliminado de la solicitud";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
					echo "No se pudo eliminar el item de la solicitud";
					?>
                 <img src="no" height="25" width="25">
                    <?php
					}
			}else{
				echo "Ningún item a eliminar<br>";
				echo "Consulte con el botón CONSULTAR<br>";
				echo "para verificar si el item existe dentro del detalle";
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>