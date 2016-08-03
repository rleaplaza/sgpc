<?php session_start();//inicio de sesion?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmaterial"])){
		require_once("../../db/connect.php");
		require_once("addIncMat.php");
		$IDsolicitud=$_POST["IDsolicitud"];
		$IDmaterial=$_POST["IDmaterial"];
		$cantidad=$_POST["cantidad"];
		#consulta para evitar reducir la cantidad de materiales cuando la solicitud ya fue atendida
		$sql=$dbh->prepare("select *from solicitud_material where Nro_solicitud=? and estado='Atendido'");
		$sql->bindParam(1,$IDsolicitud);
		$sql->execute();
		if($sql->rowCount()>0){
			echo "Solicitud atendida";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				#actualiza el estado de la solicitud 
				$update=$dbh->prepare("update solicitud_material set estado='Atendido' where Nro_solicitud=?");
				$update->bindParam(1,$IDsolicitud);
				$update->execute();
				#consulta de reducción de cantidad de materiales
		$restCantidad=$dbh->prepare("update material set cant_disponible=cant_disponible-? where IDmaterial=?");
		$restCantidad->bindParam(1,$IDmaterial);
		if($restCantidad->execute()){
			echo "Cantidad actualizada";
			?>
            <img src="yes.jpg" height="20" width="20">
            <?php
			}else{
				echo "No se pudo actualizar la cantidad";
				?>
              <img src="no.jpg" height="20" width="20">
                <?php
				}
				}
		}else{
			header("location:../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>