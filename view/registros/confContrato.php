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
		require_once("genera.php");
		try{ 
		   $idproyecto=$_POST["IDproy"];
		   $idtrabajador=$_POST["cedula"];
		   $estado="Contratado";
		   $idcontrato=generaCodigo();
		   
		   $sql=$dbh->prepare("select *from participa where CI_trabajador=?");
		   $sql->bindParam(1,$idtrabajador);
		   $sql->execute();
		   if($sql->rowCount()>0){
			   echo "El trabajador ya fue incorporado al proyecto";
			   }else{
             $insertContrato=$dbh->prepare("insert into participa values(?,?,?,?,curdate(),curtime())");
			 $insertContrato->bindParam(1,$idcontrato);
			 $insertContrato->bindParam(2,$idproyecto);
			 $insertContrato->bindParam(3,$idtrabajador);
			 $insertContrato->bindParam(4,$estado);
			 if($insertContrato->execute()){
				 echo "Trabajador asignado al contrato<br>";
				 ?>
                 <img src="yes.jpg" height="25" width="25">
                 <?php				   
				 }else{
					echo "No se pudo incorporar al trabajador";
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