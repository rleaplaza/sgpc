<?php session_start();//inicio de sesion?>
<meta charset="utf-8">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
<?php
#Este programa se encarga de registrar solicitudes de cotizacion
if(isset($_SESSION["username"])){//verifica la existencia de sesion
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");//llama a la conexion a base de datos
		try{
			$nro=$_POST["Nro"];//captura el nro de solicitud
			$idmat=$_POST["IDmaterial"];//captura el id de material
			$cant=$_POST["Cantidad"];//captura la cantidad
			#consulta del detalle de solicitud de cotizacion
			$consulta=$dbh->prepare("select *from det_solicitud_cotizacion where nro_solicitud=? and IDmaterial=?");
			$consulta->bindParam(1,$nro);
			$consulta->bindParam(2,$idmat);
			$consulta->execute();
			if(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cant)){//evalua el tipo de dato nro
			if($consulta->rowCount()>0){//mensaje de confirmacion del registro
				echo "Material ya registrado en la solicitud de cotización<br>";
				//actualiza la cantidad en caso de que la solicitud haya sido realizada
				$update=$dbh->prepare("update det_solicitud_cotizacion set cantidad_sol=? where nro_solicitud=? and                                      IDmaterial=?");
				$update->bindParam(1,$cant);
				$update->bindParam(2,$nro);
				$update->bindParam(3,$idmat);
				if($update->execute()){
				echo "Cantidad actualizada";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}
				}
			else{//consulta de la unidad del material
				$unit=$dbh->prepare("select unidad from material where IDmaterial=?");
				$unit->bindParam(1,$idmat);
				$unit->execute();
				$result=$unit->fetch();
				$unidad=$result["unidad"];//captura de la unidad
				//consulta de insercion del detalle de solicitud de cotizacion
			$insert=$dbh->prepare("insert into det_solicitud_cotizacion values(?,?,?,?)");
			$insert->bindParam(1,$nro);
			$insert->bindParam(2,$idmat);
			$insert->bindParam(3,$cant);
			$insert->bindParam(4,$unidad);
			if($insert->execute()){
				echo "Material registrado en solicitud de cotización";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				#consulta del registro de detalle de solicitud de cotizacion en caso de que exista
				$material=$dbh->prepare("SELECT descripcion, d.unidad, cantidad_sol
                                         FROM det_solicitud_cotizacion AS d, solicitud_cotizacion AS s, material AS m
                                         WHERE m.IDmaterial = d.IDmaterial
                                         AND d.nro_solicitud = s.nro_solicitud
							             and m.IDmaterial=?");
				$material->bindParam(1,$idmat);
				$material->execute();
				$resultado=$material->fetch();//devuelve el resultado en el arreglo
				?>
                <table>
                <tr><td><label>Descripción: </label></td><td><?php echo $resultado[0];?></td></tr>
                <tr><td><label>Unidad de medida: </label></td><td><?php echo $resultado[1];?></td></tr>
                <tr><td><label>Cantidad solicitada: </label></td><td><?php echo $resultado[2];?></td></tr>
                </table>
                <?php
				}else{
				echo "No se pudo registrar el detalle de solicitud";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php	
					}
			}
			}else{
				echo "El valor de la cantidad debe ser numérico";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();//genera la exepcion
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>