<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar cantidad de material consumido
if(isset($_SESSION["username"])){//verifica si existen la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	require_once("updateAvanceMat.php");//llamada a la actualización de material consumido
	if(isset($_POST["IDactividad"])){//verifica si existe la actividad
	#captura de variables 
		$idactividad=$_POST["IDactividad"];//id de activiadad
		$idmaterial=$_POST["IDmaterial"];//id de material
		$cantAsign=$_POST["CantidadAsignada"];//cantidad asignada
		$cantUsada=$_POST["CantidadUsada"];//cantidad consumida
		
		if($cantUsada>=$cantAsign){//validación de no superación de cantidad asignada
			echo "La cantidad utilizada ha superado la cantidad asignada";
			?>
            <img src="no.jpg" height="20" width="20">
            <?php
		}else{
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantUsada))){
			echo "La cantidad debe ser de valor numérico";
			?>
            <img src="no.jpg" height="20" width="20">
            <?php
			}else{#actualiza la cantidad utilizada de material
		$sql=$dbh->prepare("update actividad_material set cantidad_utilizada=cantidad_utilizada+?,                            costo_total=precio_productivo*cantidad_utilizada, fecAvance=curdate()
		                   where IDactividad=? 
		                   and IDmaterial=?");
		$sql->bindParam(1,$cantUsada);//enlaza a la cantidad usada
		$sql->bindParam(2,$idactividad);//enlaza al id de actividad
		$sql->bindParam(3,$idmaterial);//enlaza al id de material
		if($sql->execute()){
			#función para registrar el informe de uso de materiales mediante los parámetros
			updateAvanceMat($idmaterial,$idactividad,$cantUsada);
			echo "Actualización registrada";
			?>
            <img src="yes.jpg" height="20" height="20">
            <?php
			}else{
				echo "No se pudo registrar la actualización";
				?>
                <img src="no.jpg" height="20" width="20">
                <?php
				}		
				}
		}
		}else{
			header("../../index.php");//redirige al login
			}
	}else{
		header("../../index.php");//redirige al login
		}
?>
