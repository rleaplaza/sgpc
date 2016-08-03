<?php session_start();//función de inicio de sesión?>
<?php
if(isset($_SESSION["username"])){//validaciones de sesión y captura de variable, caso contrario no se podrá acceder a la página
	if(isset($_POST["IDactividad"])){
		#llamada al archivo de conexión
		require_once("../../db/connect.php");
		require_once("updatePropiedadActividad.php");
		#captura de variables de formulario
		$idactividad=$_POST["IDactividad"];
		$idmaquinaria=$_POST["IDmaq"];
		$idplan=$_POST["IDplan"];
		$unidad=$_POST["Unidad"];
		$cantidad=$_POST["Cantidad"];
		$idproyecto=$_POST["IDproy"];
		#evalúa la expresión de valor numérico
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad))){//la expreción regular evalua valores numéricos
			echo "El valor de la cantidad debe ser numerico";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
			}else{
				//consulta de la asignación
		$sql=$dbh->prepare("select *from actividad_maquinaria where IDactividad=? and IDmaquinaria=?");
		$sql->bindParam(1,$idactividad);#enlace a los parámetros de la condición where
		$sql->bindParam(2,$idmaquinaria);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Equipo ya asignado a actividad";
			}else{//consulta del precio y la cantidad de maquinaria
$consulta=$dbh->prepare("select precio_elemental,cantidad from maquinaria, proyecto_maquinaria ,proyecto
				                         where maquinaria .IDmaquinaria =proyecto_maquinaria.IDmaquinaria 
										 and proyecto_maquinaria.IDproyecto=proyecto.IDproyecto
										 and maquinaria.IDmaquinaria =?
										 and proyecto.IDproyecto=?");
				$consulta->bindParam(1,$idmaquinaria);#enlaza al id del equipo
				$consulta->bindParam(2,$idproyecto);
				$consulta->execute();//ejecuta la consulta
				$result=$consulta->fetch();//devuelve el resultado en un arreglo
				$precio=$result[0];//captura de precio elemental
				$cant_disponible=$result[1];
				if($cantidad>$cant_disponible){
					echo "La cantidad asignada supera la cantidad disponible";
					}else{
						#consulta de inserción para registro de la asignación de actividad a equipamiento
	$insert=$dbh->prepare("insert into actividad_maquinaria values(?,?,?,?,?,0.00,0.00,?,0.00,0.00,curdate(),curtime())");
	#enlace a los parámetros que serán insertados
				 $insert->bindParam(1,$idactividad);
				 $insert->bindParam(2,$idmaquinaria);
				 $insert->bindParam(3,$idplan);
				 $insert->bindParam(4,$cantidad);
				 $insert->bindParam(5,$unidad);
				 $insert->bindParam(6,$precio);
				 if($insert->execute()){//si la ejecución se realize, el registro se carga en la BD
					 echo "Asignacion registrada";
					 updateAsignacionEq($idactividad);
					 $update=$dbh->prepare("update proyecto_maquinaria set cantidad=cantidad-? where IDmaquinaria=? and IDproyecto=?");
					 $update->bindParam(1,$cantidad);
					 $update->bindParam(2,$idmaquinaria);
					 $update->bindParam(3,$idproyecto);
					 $update->execute();
					 ?>
                    <img src="yes.jpg" height="25" width="25">
                     <?php
					 }else{//mensaje de error en el registro
						 echo "No se pudo registrar la asignacion";
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