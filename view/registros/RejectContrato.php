<?php session_start();?>
<!doctype html>
<html>
<meta charset="utf-8">
 <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	</style>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproy"])){
		require_once("../../db/connect.php");
		try{ 
		   $idproyecto=$_POST["IDproy"];
		   $idtrabajador=$_POST["cedula"];
		   $estado="Rechazado";
		   $sql=$dbh->prepare("update participa set estado_contratacion=? where IDproyecto=? and CI_trabajador=?");
		   $sql->bindParam(1,$estado);
		   $sql->bindParam(2,$idproyecto);
		   $sql->bindParam(3,$idtrabajador);
		   if($sql->execute()){
			   echo "Trabajador contratado para el proyecto";
$consulta=$dbh->prepare("select pm.nombre, ap_p, ap_m, c.nombre, estado_contratacion,fechaContratacion, hraContratacion 
			             FROM personalmanoobra as pm, proyecto as p, participa as ct, cargomanodeobra as c
						 where pm.CI_trabajador=ct.CI_trabajador
						 and ct.IDproyecto=p.IDproyecto
						 and pm.IDcargoM=c.IDcargoM
						 and pm.CI_trabajador=?
						 and p.IDproyecto=?");
				$consulta->bindParam(1,$idtrabajador);
				$consulta->bindParam(2,$idproyecto);
				$consulta->execute();
				$result=$consulta->fetch();
			   ?>
               <table>
               <th><label>Datos de confirmación</label></th>
               <tr><td><label>Trabajador: </label></td><td><?php echo $result[0]." ".$result[1]." ".$result[2];?></td></tr>
               <tr><td><label>Cargo: </label></td><td><?php echo $result[3];?></td></tr>
               <tr><td><label>Estado de contratación: </label></td><td><?php echo $result[4];?></td></tr>
               <tr><td><label>Fecha de contratación: </label></td><td><?php echo $result[5];?></td></tr>
               <tr><td><label>Hora de contratación: </label></td><td><?php echo $result[6];?></td></tr>
               </table>
               <img src="no.jpg" height="25" width="25">
               <?php
			   }else{
			   echo "No se pudo actualizar el contrato";
			   ?>
               <img src="no.jpg" height="25" width="25">
               <?php	   
				   }
			
			}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>
</html>