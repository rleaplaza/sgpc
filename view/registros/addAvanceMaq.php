<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar avance y utilidad de equipamiento
if(isset($_SESSION["username"])){//valida que las variables existan caso contrario no se puede acceder al programa
	if(isset($_POST["IDactividad"])){
		require_once("../../db/connect.php");//llama a la conexión a base de datos
		require_once("updateAvanceMaq.php");//archivo para actualizar el uso de equipamiento
		#captura de variables
		$idactividad=$_POST["IDactividad"];
		$idmaquinaria=$_POST["IDmaquinaria"];
		$horaInicio=$_POST["HoraInicio"];
		$horaFin=$_POST["HoraFin"];
		$unidad=$_POST["Unidad"];
		$cant_usada=$_POST["Cant_usada"];
		$pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])[\:]([0-5][0-9])$/";//expresión regular para validar formato de hora
		#expresión regulara para validar que el campo total sea numérico decimal
		if($cant_usada!=0){
			if($horaInicio<$horaFin){
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cant_usada))){
		echo "El valor de cantidad debe ser numérico";//mensaje de error
		?>
        <img src="no.jpg" height="20" width="20">
        <?php
		}else{
		     if(preg_match($pattern,$horaInicio) && preg_match($pattern,$horaFin)){
				 $diferencia=resta($horaInicio,$horaFin);
				 $horas=Decimal($diferencia);
			#consulta para recuperar el precio productivo de la maquinaria
		$sql=$dbh->prepare("select precio_productivo from actividad_maquinaria where IDactividad=? and IDmaquinaria=?");
		$sql->bindParam(1,$idactividad);//enlaza el id de actividad
		$sql->bindParam(2,$idmaquinaria);//enlaza el id del equipamiento
		$sql->execute();//ejecuta la instrucción
		if($sql->rowCount()>0){//condición que verifica si existe más de un registro
			$row=$sql->fetch();//devuelve el resultado en un arreglo
			$precio=$row[0];//asigna el indice del precio productivo a la variable
			}
			//calcula el costo, precio por el total por el avance acumulado del uso
		$total_horas=$cant_usada*$horas;
	    $costoTotal=$precio*$horas;
		#consulta de actualización de la actividad en el equipamiento
		$update=$dbh->prepare("update actividad_maquinaria set total_horas=total_horas+?,cantidad_usada=?, costo_total=?, fechaAvance=curdate() where IDactividad=? and IDmaquinaria=?");
		$update->bindParam(1,$total_horas);
		$update->bindParam(2,$cant_usada);
		$update->bindParam(3,$costoTotal);
		$update->bindParam(4,$idactividad);
		$update->bindParam(5,$idmaquinaria);
		if($update->execute()){//actualiza el informe de avances para los equipamientos
			updateAvance($idmaquinaria,$idactividad,$unidad,$horas,$cant_usada);
			echo "Uso actualizado";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				echo "Error al actualizar el informe";
				?>
                <img src="no.jpg" height="20" width="20">
                <?php
				}
		}else{
			echo "Al menos el formato de hora de un campo es incorrecto";
			?>
               <img src="no.jpg" height="20" width="20">
			<?php
			}
		}
		}else{
			echo "La hora de inicio es mayor";
			}
		}else{
			echo "No se permiten cantidades iguales a cero";
			}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
 function resta($inicio, $fin){
  $dif=date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio) );
  return $dif;
  }
  function Decimal($hora){
  $desglose=explode(":", $hora);
  $dec=$desglose[0]+$desglose[1]/60;
  return $dec;
  }
?>