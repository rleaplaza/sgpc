<?php
session_start();
?>
<html>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproy"])){
		require_once("../../db/connect.php");
		require_once("genera.php");
		try{
			$idtrabajador=$_POST["codTrabajador"];
			$idproyecto=$_POST["IDproy"];
			$cant_sol=intval($_POST["Cantidad"]);
			$idsol=$_POST["IDsolicitud"];
			$idcontrato=generaCodigo();
			$estado="Contratado";
			$uidplan=$_POST["IDplan"];
			//consultar si el trabjador ya está pendiente de contratación
			$sql=$dbh->prepare("select *from participa where IDproyecto=? and CI_trabajador=?");
			$sql->bindParam(1,$idproyecto);
			$sql->bindParam(2,$idtrabajador);
			$sql->execute();
			if($sql->rowCount()>0){
				echo "Trabajador ya incorporado en la solcitud";
				}else{
					// consulta la cantidad de trabajadores asignados
				$aux=$dbh->prepare("select cantidad_contratada from solicita where IDsolicitud=? and IDproyecto=?");
				 $aux->bindParam(1,$idsol);
				 $aux->bindParam(2,$idproyecto);
				 $aux->execute();
				 $result=$aux->fetch();
				 $cant_contratada=intval($result["cantidad_contratada"]);	
				 if($cant_sol==$cant_contratada){
					 echo "La solicitud ya fue atendida"; // esta validación no permite que se agreguen más trabajadores de lo solicitado     ?>
                     <img src="yes.jpg" height="25" width="25">
                     <?php
					 }else{	//insertará al nuevo trabajador en la solicitud del proyecto
					 $insert=$dbh->prepare("insert into participa values(?,?,?,?,?,'no',curdate(),curtime())");
				 $insert->bindParam(1,$idcontrato);
				 $insert->bindParam(2,$idproyecto);
				 $insert->bindParam(3,$uidplan);
				 $insert->bindParam(4,$idtrabajador);
				 $insert->bindParam(5,$estado);
				 if($insert->execute()){ // actualiza la cantidad incorporada en la solicitud del proyecto
				 $query=$dbh->prepare("update solicita set cantidad_contratada=cantidad_contratada+1 where IDsolicitud=?");
				 $query->bindParam(1,$idsol);
				 $query->execute();
				 echo "Trabajador agregado a solicitud"; //confirma la incorporación
				 ?>
                 <img src="yes.jpg" height="25" width="25"><br>
                 <?php
				 }else{
					 echo "No se pudo incorporar al trabajador en la solicitud";
					 ?>
                    <img src="no.jpg" height="25" width="25">
                     <?php
					 } // vuelve a consultar la cantidad incorporada al proyecto
			 $consulta=$dbh->prepare("select cantidad_contratada from solicita where IDsolicitud=? and IDproyecto=?");
				 $consulta->bindParam(1,$idsol);
				 $consulta->bindParam(2,$idproyecto);
				 $consulta->execute();
				 $result=$consulta->fetch();
				 $cant_contratada=intval($result["cantidad_contratada"]);	 
					
				 if($cant_sol==$cant_contratada){
				  $nuevoEstado="Atendido";
				  $update=$dbh->prepare("update solicita set estado=? where IDsolicitud=?");
				  $update->bindParam(1,$nuevoEstado);
				  $update->bindParam(2,$idsol);
				  if($update->execute()){
					   echo "Solicitud atendida";
					   ?>
                        <img src="yes.jpg" height="25" width="25">   
                       <?php
					  }else{
						 echo "No se pudo completar la solicitud"; 
						  }
					 }
					 }
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