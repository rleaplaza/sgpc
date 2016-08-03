<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDpedido"])){
		require_once("../../db/connect.php");
		$idpedido=$_POST["IDpedido"];
		$idmaterial=$_POST["IDmaterial"];
		$desc=$_POST["Desc"];
		$cantidad=$_POST["Cant"];
		$precio=$_POST["Precio"];
		if(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad)){
			$sql=$dbh->prepare("update det_pedido set cantidad=?, subtotal=precio*? where IDpedido=? and IDmaterial=?");
			$sql->bindParam(1,$cantidad);
			$sql->bindParam(2,$cantidad);
			$sql->bindParam(3,$idpedido);
			$sql->bindParam(4,$idmaterial);
			if($sql->execute()){
				echo "Detalle actualizado";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
					echo "No se pudo actualizar el registro";
					}
			}else{
				echo "El valor de la cantidad debe ser numérico";
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