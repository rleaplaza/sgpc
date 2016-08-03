<?php session_start();//funcion de inicio de sesion?>
<meta charset="utf-8">
<?php
#Este programa realiza el registro de pedido de materiales que realiza la empresa a proveedores
#POWERD BY SERCO SRL
if(isset($_SESSION["username"])){#validación de la variable de sesión para evitar ingresar al programa
	if(isset($_POST["Nropedido"])){#validación de variable para evitar ingresar al programa en caso de inexistencia
		require_once("../../db/connect.php");
		$nroPedido=$_POST["Nropedido"];
		$nrocotizacion=$_POST["Nrocotizacion"];
		//consulta el detalle de pedido según el nro de cotización
		$consulta=$dbh->prepare("SELECT * FROM det_pedido, pedido_material
                                 WHERE det_pedido.nro_pedido = pedido_material.nro_pedido
                                 AND pedido_material.nro_cotizacion = ?");
		$consulta->bindParam(1,$nrocotizacion);
		$consulta->execute();
		if($consulta->rowCount()>0){//mensaje para evitar repetición de registros
			echo "Detalle de pedido ya registrado<br>";
			echo "Presione el botón consultar"
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				#consulta del detalle de cotización
		$sql=$dbh->prepare("SELECT material.IDmaterial,det_cotizacion.unidad, cantidad_sol, precio_unitario,                            subtotal
                            FROM det_cotizacion, material
                            WHERE material.IDmaterial = det_cotizacion.IDmaterial
							and det_cotizacion.nro_cotizacion=?");
		$sql->bindParam(1,$nrocotizacion);
		$sql->execute();
		if($sql->rowCount()>0){
			$subtotalC=0;
			foreach($sql->fetchAll() as $row){
		#dentro del arreglo, las variables seleccionadas se almacenan para registrarlas en el detalle de pedido
				$idmaterial=$row[0];
				$unidad=$row[1];
				$cantidad=$row[2];
				$precio=$row[3];
				$subtotal=$row[4];
		#registro de las variables del arreglo en el detalle del pedido, el detalle de pedido se registrará según el nro de filas del detalle de cotización
				$insert=$dbh->prepare("insert into det_pedido values(?,?,?,?,?,?)");
				$insert->bindParam(1,$nroPedido);
				$insert->bindParam(2,$idmaterial);
				$insert->bindParam(3,$unidad);
				$insert->bindParam(4,$cantidad);
				$insert->bindParam(5,$precio);
				$insert->bindParam(6,$subtotal);
				$insert->execute();
	#sumatoria del subtotal de pedido
				$subtotalC=$subtotalC+$subtotal;
				}
		#consulta de confirmación para el pedido
			$query=$dbh->prepare("select *from det_pedido where nro_pedido=?");
			$query->bindParam(1,$nroPedido);
			$query->execute();
			if($query->rowCount()>0){
				echo "Detalle de pedido registrado";
				?>
                <img src="yes.jpg" height="25" width="25"><br>
                <?php
				$iva=$subtotalC*0.13;
				$total=$subtotalC-$iva;
		#cálculo del total a pagar dentro del pedido a actualizar
				$update=$dbh->prepare("update pedido_material set subtotal=?,iva=?,total=?, estado='Atendido' where nro_pedido=?");
				$update->bindParam(1,$subtotalC);
				$update->bindParam(2,$iva);
				$update->bindParam(3,$total);
				$update->bindParam(4,$nroPedido);
				if($update->execute()){#mensaje de confirmación del pedido
					echo "Pedido actualizado";
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}
				}else{#mensaje de error, el cual no debería desplegarse
					echo "No se pudo registrar el detalle de pedido";
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
					}
				
			}	
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>