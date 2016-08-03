<?php session_start();?>
<meta charset="utf-8">
<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
if(isset($_POST["NroPedido"])){
	try{
		$nroPedido=$_POST["NroPedido"];
		$sql=$dbh->prepare("select *from pedido_material where estado in ('Atendido','Cancelado') and nro_pedido=?");
		$sql->bindParam(1,$nroPedido);
		$sql->execute();
		if($sql->rowCount()==0){
			$update=$dbh->prepare("update pedido_material set estado='Cancelado' where nro_pedido=?");
			$update->bindParam(1,$nroPedido);
			if($update->execute()){
				echo "Pedido cancelado";
				?>
                <img src="yes.jpg" height="20" width="20">
                <?php
				}else{
					echo "No se pudo cancelar el pedido";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php
					}
			}else{
				echo "El pedido fue procesado";
				}
		}catch(PDOException $e){
			echo "Error inesperado ".$e->getMessage();
			}
	}else{
		header("location: ../../index.php");
		}
 }else{
	 header("location: ../../index.php");
	 }
?>