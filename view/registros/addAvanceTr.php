<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDactividad"])){
		require_once("../../db/connect.php");
		require_once("histAvance.php");
		require_once("updateDiasUsados.php");
		#captura de variables
		$idactividad=$_POST["IDactividad"];
		$ci=$_POST["CI"];
		$totaltr=$_POST["Horas"];
		$unidadav=$_POST["UnidadAvance"];
		$totalAvance=$_POST["TotalAvance"];
		$unidadTrabajo=$_POST["UnidadTrabajo"];
		$cantprog=$_POST["CantProg"];
		$desc=$_POST["Desc"];
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$totalAvance))){
			echo "El valor del avance debe ser numérico";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
			} else {
				$query=$dbh->prepare("select total_avance from actividad where IDactividad=?");
				$query->bindParam(1,$idactividad);
				$query->execute();
				if($query->rowCount()>0){
					$result=$query->fetch();
					$cantFinal=$result[0];
					}
				if($cantFinal>=$cantprog){
					echo "La cantidad final ha superado la cantidad programada";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}else{
		#consulta de precio productivo
		$consulta=$dbh->prepare("select precio_productivo from actividad_trabajador where IDactividad=? and CI_trabajador=?");
		$consulta->bindParam(1,$idactividad);
		$consulta->bindParam(2,$ci);
		$consulta->execute();
		$row=$consulta->fetch();
		$precioProductivo=$row[0];
		$subtotal=$precioProductivo*$totaltr;
		#actualización del avance
		$sql=$dbh->prepare("update actividad_trabajador set total_trabajo=?,unidad_avance=?,total_unidad_avance=total_unidad_avance+?,subtotal_manoObra=?,fecha_avance=curdate() where IDactividad=? and CI_trabajador=?");
		$sql->bindParam(1,$totaltr);
		$sql->bindParam(2,$unidadav);
		$sql->bindParam(3,$totalAvance);
		$sql->bindParam(4,$subtotal);
		$sql->bindParam(5,$idactividad);
		$sql->bindParam(6,$ci);
		if($sql->execute()){
			#actualizacion del total avanzado para la actividad
			echo "Avance de actividad actualizado";
			histAvance($ci,$idactividad,$unidadTrabajo,$totaltr,$unidadav,$totalAvance,$desc);
			updateDias($idactividad);
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo actualizar el avance";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}
			}
			}
	}
	}else{
		header("location: ../../index.php");
		}
?>