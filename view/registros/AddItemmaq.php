<?php session_start();?>

<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmaquinaria"])){
		require_once("../../db/connect.php");
		require_once("addItemMaq1.php");
		$IDmaquinaria=$_POST["IDmaquinaria"];
		$IDsol=$_POST["IDsolicitud"];
		$consulta=$dbh->prepare("select * from solicitud_maquinaria where estado='Atendido'");
		$consulta->execute();
		if($consulta->rowCount()>0){
			echo "Solicitud atendida<br>";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
	    $prepare=$dbh->prepare("select cantidad_sol from solicitud_maquinaria where IDsolicitud=? and IDmaquinaria=?");
		$prepare->bindParam(1,$IDsol);
		$prepare->bindParam(2,$IDmaquinaria);
		$prepare->execute();
		$result=$prepare->fetch();
		$cant_sol=$result[0];
		 
		 $update=$dbh->prepare("update maquinaria set cant_disponible=? where IDmaquinaria=?");
		 $update->bindParam(1,$cant_sol);
		 $update->execute();
		 
		 $estado=$dbh->prepare("update solicitud_maquinaria set estado='Atendido' where IDsolicitud=?");
		 $estado->bindParam(1,$IDsol);
		 $estado->execute();
		 
		 if(insertItemMaq($cant_sol)){
			 echo "Solicitud atendida";
			 ?>
             <img src="yes.jpg" height="25" width="25">
             <?php
			 }else{
				echo "No se pudo completar la solicitud";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php 
				 }	
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>