<?php session_start();?>
<meta charset="utf-8">
<?php
#Este programa se encarga de realizar la solicitud de materiales a almacenes y destinarlos a una actividad.
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmat"])){
		require_once("../../db/connect.php");//conexión a base de datos
		$Nro=$_POST["Nro"];
		//Datosde pedido
		$IDact=$_POST["IDact"];
        $IDemp=$_POST["IDemp"];
		$IDpt=$_POST["IDpt"];
		$Desc=$_POST["Desc"];
		//Datos del detalle de pedido
		$IDmat=$_POST["IDmat"];
        $Cantidad=$_POST["Cantidad"];
		$nombre=$_POST["Nombre"];
		#consulta de la cantidad disponible
		if($IDpt!=""){
		$consulta=$dbh->prepare("select cant_disponible from material where IDmaterial=?");
		$consulta->bindParam(1,$IDmat);
		$consulta->execute();
		$result=$consulta->fetch();
		$cantidad_disponible=$result[0];
	if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$Cantidad))){
		
		echo "El valor de la cantidad debe ser numérico";
		?>
        <img src="no.jpg" height="20" width="20">
        <?php
		}else{
		if($Cantidad>$cantidad_disponible){
			echo "La cantidad solicitada es mayor a la disponible";
			?>
            <img src="no.jpg" height="20" width="20">
            <?php
			}else{
		#consulta de detalle
		$sql=$dbh->prepare("select *from det_pedido_almacen where Nro_pedido=? and IDmaterial=?");
		$sql->bindParam(1,$Nro);
		$sql->bindParam(2,$IDmat);
		$sql->execute();
		if($sql->rowCount()>0){
			#actualiza la cantidad en caso de que se vuelva a ingresar por el formulario
			$update=$dbh->prepare("update det_pedido_almacen set cantidad_sol=cantidad_sol+? where IDmaterial=? and Nro_pedido=?");
			$update->bindParam(1,$Cantidad);
			$update->bindParam(2,$IDmat);
			$update->bindParam(3,$Nro);
			$update->execute();
			echo "Cantidad actualizada";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				$select=$dbh->prepare("select *from material where IDmaterial=?");
				$select->bindParam(1,$IDmat);
				$select->execute();
				foreach($select->fetchAll() as $fila){//recorre las filas en base al material solicitado
					$Unidad=$fila["unidad"];//captura la unidad
					#registro del detalle de pedido en almacen en base al arreglo de la consulta
					$insert=$dbh->prepare("insert into det_pedido_almacen values(?,?,?,?)");
					$insert->bindParam(1,$Nro);
					$insert->bindParam(2,$IDmat);
					$insert->bindParam(3,$Cantidad);
					$insert->bindParam(4,$Unidad);
					$insert->execute();
					}
				#consulta de recuperación de detalle
				$det=$dbh->prepare("select *from det_pedido_almacen where Nro_pedido=?");
				$det->bindParam(1,$Nro);
				$det->execute();
				if($det->rowCount()>0){
					$update=$dbh->prepare("update pedido_almacen set IDempleado=?,IDpersonalTecnico=?,descripcion=?                                           where Nro_pedido=?");
			        $update->bindParam(1,$IDemp);
					$update->bindParam(2,$IDpt);
					$update->bindParam(3,$Desc);
					$update->bindParam(4,$Nro);
					if($update->execute()){
						echo "Pedido registrado en almacén";
						?>
                        <img src="yes.jpg" height="20" width="20">
                        <?php
						}else{
							echo "No se pudo registrar el pedido";
							?>
                            <img src="no.jpg" height="20" width="20">
                            <?php
							}
					
					}else{
						echo "Detalle de almacén no encontrado";
						echo $Unidad;
						}
				}
			}
		}
		}else{
			echo "Usted no fue asignado al proyecto";
			}
	}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>