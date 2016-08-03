<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");
		$nro=$_POST["Nro"];
		$estado="atendido";
		$update=$dbh->prepare("update pedido_almacen set estado=? where Nro_pedido=?");
		$update->bindParam(1,$estado);
		$update->bindParam(2,$nro);
		if($update->execute()){
			echo "Pedido atendido";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				echo "No se pudo actualizar la solicitud";
				?>
              <img src="no.jpg" height="20" width="20">
                <?php
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>