<?php session_start();//función de inicio de sesión?>
<?php
#Este programa se encarga de registrar asignaciones de actividades a materiales
if(isset($_SESSION["username"])){//verifica la existencia de sesión
	if(isset($_POST["IDactividad"])){//verifica la existencia de la actividad
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		require_once("updatePropiedadActividad.php");
		$idactividad=$_POST["IDactividad"];//captura el id de la actividad
		$idmaterial=$_POST["IDmat"];//id de material
		$idplan=$_POST["IDplan"];//id de planeación
		$unidad=$_POST["Unidad"];//unidad de trabajo
		$cantidad=$_POST["Cantidad"];//cantidad de material
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad))){//evalúa el valor de la cantidad
			echo "El valor de la cantidad debe ser numerico";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
			}else{
		#consulta de la asignación
		$sql=$dbh->prepare("select *from actividad_material where IDactividad=? and IDmaterial=?");
		$sql->bindParam(1,$idactividad);//enlaza al id de actividad
		$sql->bindParam(2,$idmaterial);//enlaza al id de material
		$sql->execute();
		if($sql->rowCount()>0){//si hay una fila entonces significa que la asignación ya fue registrada
			echo "Material ya asignado a actividad";
			}else{
				#consulta del precio unitario del materil y la cantidad
				$consulta=$dbh->prepare("select precio_bs, cant_disponible from material where IDmaterial=?");
				$consulta->bindParam(1,$idmaterial);
				$consulta->execute();
				$result=$consulta->fetch();
				$precio=$result[0];
				$cant_disponible=$result[1];
				if($cantidad>$cant_disponible){
					echo "La cantidad asignada supera la cantidad disponible";
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
						#actualiza la tabla que relaciona al proyecto con los materiales
						$updateCantidad=$dbh->prepare("update proyecto_material set cantidad=cantidad-? where                                                        IDmaterial=?");
						$updateCantidad->bindParam(1,$cantidad);
						$updateCantidad->bindParam(2,$idmaterial);
						$updateCantidad->execute();
			     $costo=$cantidad*$precio;//cálculo del costo para la asignación
				 #consulta para registrar la asignación
	$insert=$dbh->prepare("insert into actividad_material values(?,?,?,?,?,0.00,0.00,?,?, null,curdate(),curtime())");
				 $insert->bindParam(1,$idactividad);//enlaza al id de actividad
				 $insert->bindParam(2,$idmaterial);//enlaza al id de material
				 $insert->bindParam(3,$idplan);//enlaza al id de planeación
				 $insert->bindParam(4,$unidad);//enlaza a la unidad
				 $insert->bindParam(5,$cantidad);//enlaza a la cantidad
				 $insert->bindParam(6,$precio);//enlaza el precio
				 $insert->bindParam(7,$costo);//enlaza el valor de costo
				 if($insert->execute()){
					 echo "Asignacion registrada";//mensaje de confirmación
					  updateAsignacionMat($idactividad);
					 ?>
                    <img src="yes.jpg" height="25" width="25">
                     <?php
					 }else{
						 echo "No se pudo registrar la asignacion";//mensaje de fallo
						 ?>
                       <img src="no.jpg" height="25" width="25">
                         <?php
						 }
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