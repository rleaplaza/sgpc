<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php 
#Este programa se encarga de procesar pedidos de almacén mediante entrega e incorporación al proyecto
if(isset($_SESSION["username"])){
	if(isset($_POST["NroEntrega"])){
		require_once("../../db/connect.php");//llamada al archivo de conexión a las base de datos
		require_once("generaNumero.php");
		require_once("updateCantidadMaterialE.php");
		$idIncor=generaNumero();
		$NroEntrega=$_POST["NroEntrega"];
		$IDpedido=$_POST["IDpedido"];
		$IDproyecto=$_POST["IDproyecto"];
		$IDplan=$_POST["IDplan"];
		$IDactividad=$_POST["IDactividad"];
		$sql=$dbh->prepare("select *from entrega where Nro_entrega=? and estado='Atendido'");
		$sql->bindParam(1,$NroEntrega);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Entrega ya realizada";
			?>
            <img src="no.jpg" height="20" width="20">
            <?php
			}else{
				$consulta=$dbh->prepare("select *from det_pedido_almacen where Nro_pedido=?");
				$consulta->bindParam(1,$IDpedido);
				$consulta->execute();
				if($consulta->rowCount()>0){
					foreach($consulta->fetchAll() as $row){
						$IDmaterial=$row[1];
						$Cantidad=$row[2];
						$Unidad=$row[3];
						#inserción a la entraga
					    $insertDetEntrega=$dbh->prepare("insert into det_entrega values(?,?,?,?)");
						$insertDetEntrega->bindParam(1,$NroEntrega);
						$insertDetEntrega->bindParam(2,$IDmaterial);
						$insertDetEntrega->bindParam(3,$Cantidad);
						$insertDetEntrega->bindParam(4,$Unidad);
						if($insertDetEntrega->execute()){
					#inserta el material incorporado al proyecto
			$insertMaterial=$dbh->prepare("insert into proyecto_material values(?,?,?,?,?,curdate(),curtime())");
			$insertMaterial->bindParam(1,$idIncor);
			$insertMaterial->bindParam(2,$IDproyecto);
			$insertMaterial->bindParam(3,$IDplan);
			$insertMaterial->bindParam(4,$IDmaterial);
			$insertMaterial->bindParam(5,$Cantidad);
			$insertMaterial->execute();
			
			#actualiza la cantidad de material del almacén
			$update=$dbh->prepare("update material set cant_disponible=cant_disponible-? where IDmaterial=?");
			$update->bindParam(1,$Cantidad);
			$update->bindParam(2,$IDmaterial);
			$update->execute();
							}
						}
						$updateEntrega=$dbh->prepare("update entrega set estado='Atendido' where Nro_entrega=?");
							$updateEntrega->bindParam(1,$NroEntrega);
							if($updateEntrega->execute()){
								updateCantidadAsignada($IDactividad,$IDmaterial,$Cantidad);
								echo "Entrega realizada";
								#actualización del pedido
			$updatePedido=$dbh->prepare("update pedido_almacen set estado='Atendido' where Nro_pedido=?");
			$updatePedido->bindParam(1,$IDpedido);
			$updatePedido->execute();
								?>
                                <img src="yes.jpg" height="20" width="20">
                                <?php
								}else{
									echo "No se pudo actualizar la entrega";
									?>
                                    <img src="no.jpg" height="20" width="20">
                                    <?php
									}
					}
				}
		}else{
			header("../../index.php");
			}
	}else{
		header("../../index.php");
		}
?>
