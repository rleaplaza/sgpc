<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDpedido"])){
		try{
		require_once("../../db/connect.php");
		$idpedido=$_POST["IDpedido"];
		//consulta si el estado del pedido se ha completado
		$consulta=$dbh->prepare("select * from pedido_material where estado='Atendido' and IDpedido=?");
		$consulta->bindParam(1,$idpedido);
		$consulta->execute();
		if($consulta->rowCount()>0){
		 echo "Este pedido ya se ha completado en el sistema";
		 ?>
         <img src="yes.jpg" height="25" width="25">
         <?php
		}else{
		$sql=$dbh->prepare("select *from det_pedido where IDpedido=?");
		$sql->bindParam(1,$idpedido);
		$sql->execute();
		if($sql->rowCount()>0){
			$subtotal=0;
			foreach($sql->fetchAll() as $row){
				$aux=$row["subtotal"];
				$subtotal=$subtotal+$aux;
				}
				$subtotalC=$subtotal;
				$iva=$subtotalC*0.13;
				$total=$subtotalC-$iva;
				$estado="Atendido";
				$update=$dbh->prepare("update pedido_material set subtotal=?, iva=?, total=?, estado=? where IDpedido=?");
				$update->bindParam(1,$subtotalC);
				$update->bindParam(2,$iva);
				$update->bindParam(3,$total);
				$update->bindParam(4,$estado);
				$update->bindParam(5,$idpedido);
				if($update->execute()){
					echo "Pedido procesado";
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
						echo "No se pudo actualizar el pedido";
						?>
                        <img src="no.jpg" height="25" width="25">
                        <?php
						}
			}else{
				echo "No se encontraron resultados del pedido";
				?>
                <img src="no.jpg" height="20" width="20">
                <?php
				}
		}
		
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>