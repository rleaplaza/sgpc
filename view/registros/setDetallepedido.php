<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDpedido"])){
		require_once("../../db/connect.php");
		$idpedido=$_POST["IDpedido"];
		$idmaterial=$_POST["IDmat"];
		$precio=$_POST["Precio"];
		// captura del precio
		$precio=$dbh->prepare("select precio_bs from material where IDmaterial=?");
		$precio->bindParam(1,$idmaterial);
		$precio->execute();
		$res=$precio->fetch();
		$precio=$res["precio_bs"];
		
		//consulta la existencia del material dentro del pedido
		$consulta=$dbh->prepare("select *from det_pedido where IDpedido=? and IDmaterial=? and cantidad>0");
		$consulta->bindParam(1,$idpedido);
		$consulta->bindParam(2,$idmaterial);
		$consulta->execute();
		//actualiza la cantidad si el material ya se encuentra registrado para el pedido
		if($consulta->rowCount()>0){
		 echo "Material registrado en detalle<br>";
		 $update=$dbh->prepare("update det_pedido set cantidad=cantidad+1, subtotal=cantidad*? where IDpedido=? and IDmaterial=?");
		 $update->bindParam(1,$precio);
		 $update->bindParam(2,$idpedido);
		 $update->bindParam(3,$idmaterial);
		 if($update->execute()){
			 echo "Cantidad actualizada";
			 ?>
             <img src="yes.jpg" height="25" width="25">
             <?php
			 }	
			}else{
				// Registra el detalle
				$cantidad=1;
				$subtotal=$precio*$cantidad;
		 $insert=$dbh->prepare("insert into det_pedido values(?,?,?,?,?)");
		 $insert->bindParam(1,$idpedido);
		 $insert->bindParam(2,$idmaterial);
		 $insert->bindParam(3,$cantidad);
		 $insert->bindParam(4,$precio);
		 $insert->bindParam(5,$subtotal);
		 if($insert->execute()){
			 echo "Material registrado en pedido";
			 ?>
             <img src="yes.jpg" height="25" width="25">
             <?php
			 }else{
				echo "No se pudo registrar el detalle";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php 
				 }
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>