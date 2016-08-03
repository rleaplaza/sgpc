<?php session_start();//inicio de la sesion?>
<?php
require_once("../../db/connect.php");//llama a la conexion global
if(isset($_SESSION["username"])){//verifica si existe la sesion
	if(isset($_POST["IDactividad"])){//verifica si existe la actividad
		$IDactividad=$_POST["IDactividad"];
	$sql=$dbh->prepare("select total_unidad_avance from actividad_trabajador where IDactividad=?");
	$sql->bindParam(1,$IDactividad);
	$sql->execute();
	if($sql->rowCount()>0){
		$total_avance=0;
		foreach($sql->fetchall() as $result){
			$total_avance=$total_avance+$result[0];//suma el total avanzado por trabajador
		}
		#actualiza el total avanzado para la actividad
	$update=$dbh->prepare("update actividad set total_avance=? where IDactividad=?");
	$update->bindParam(1,$total_avance);
	$update->bindParam(2,$IDactividad);
	if($update->execute()){
		echo "Avance actualizado";
		?>
        <img src="yes.jpg" height="20" width="20">
        <?php
		}else{
			echo "No se pudo actualizar el avance";
			?>
            <img src="no.jpg" height="20" width="20">
            <?php
			}
	}
		}
	}
?>