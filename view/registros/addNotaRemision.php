<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar notas de remisión de proveedores
if(isset($_SESSION["username"])){//varifica la existencia de la sesión
	if(isset($_POST["Nronota"])){//verifica que el nro de nota 
	require_once("../../db/connect.php");//llamada a la conexión a base de datos
	require_once("insertItem.php");
		try{
			$nroNota=$_POST["Nronota"];//captura el nro de nota
			$nropedido=$_POST["Nropedido"];//captura el nro de pedido
			$consulta=$dbh->prepare("SELECT * FROM nota_remision, det_notaremision
                                      WHERE nota_remision.nro_nota = det_notaremision.nro_nota
                                      AND nota_remision.nro_nota=?");
			$consulta->bindParam(1,$nroNota);//enlaza al nro de la nota
			$consulta->execute();//ejecuta la instrucción
			if($consulta->rowCount()>0){
				echo "Detalle de nota de remisión ya registrado<br>";//mensaje de confirmación
				echo "Presione el botón consultar";//indicación para consultar el registro
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}
			else{
				//consulta el detalle de pedido
			$sql=$dbh->prepare("select *from det_pedido where nro_pedido=?");
			$sql->bindParam(1,$nropedido);//enlaza al nro de pedido
			$sql->execute();
			foreach($sql->fetchAll() as $row){ //recorre el arreglo para insertar el detalle de nota de remisión
				$idmaterial=$row["IDmaterial"];
				$unidad=$row["unidad"];
				$cantidad=$row["cantidad"];
				$precio=$row["precio"];
			    $insert=$dbh->prepare("insert into det_notaremision values(?,?,?,?,?)");
				$insert->bindParam(1,$nroNota);
				$insert->bindParam(2,$idmaterial);
				$insert->bindParam(3,$unidad);
				$insert->bindParam(4,$cantidad);
				$insert->bindParam(5,$precio);
				$insert->execute();
				
				$consultaMaterial=$dbh->prepare("select *from material where IDmaterial=?");
				$consultaMaterial->bindParam(1,$idmaterial);
				$consultaMaterial->execute();
				if($consultaMaterial->rowCount()>0){
					//actualiza la cantidad de materiales a partir del almacén
					$update=$dbh->prepare("update material set cant_disponible=cant_disponible+? where IDmaterial=?");
					$update->bindParam(1,$cantidad);
					$update->bindParam(2,$idmaterial);
					$update->execute();
					}
				}//consulta el detalle de remision
			  $query=$dbh->prepare("select *from det_notaremision where nro_nota=?");
			  $query->bindParam(1,$nroNota);
			  $query->execute();
			  if($query->rowCount()>0){
				  echo "Detalle de nota de remisión registrado";//mensaje de confirmacion
				  ?>
                  <img src="yes.jpg" height="25" width="25">
                  <?php
				  }else{
					 echo "No se pudo registrar el detalle de remisión";
					 ?>
                     <img src="no.jpg" height="25" width="25">
                     <?php 
					  }
			}
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");
		}
?>
