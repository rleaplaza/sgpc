<?php session_start();?>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproyecto"])){
		require_once("../../db/connect.php");
		require_once("generaNumero.php");
		try{
			
			$uidproyecto=$_POST["IDproyecto"];
			$uidplan=$_POST["IDplan"];
		
			#consulta la incorporación
			$consulta=$dbh->prepare("select *from proyecto_material where IDproyecto=?");
			$consulta->bindParam(1,$uidproyecto);
			$consulta->execute();
			if($consulta->rowCount()>0){
				echo "Materiales ya incorporados";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}else{
				#consulta de los materailes en almacen
			   $query=$dbh->prepare("select IDmaterial, cant_disponible from material where cant_disponible>0");
			   $query->execute();
			   foreach($query->fetchAll() as $fila){
				   $uidmaterial=$fila[0];
				   $cantidad=$fila[1];
				   $uidIncor=generaNumero();
			  $insert=$dbh->prepare("insert into proyecto_material values(?,?,?,?,?,curdate(),curtime())");
			  $insert->bindParam(1,$uidIncor);
			  $insert->bindParam(2,$uidproyecto);
			  $insert->bindParam(3,$uidplan);
			  $insert->bindParam(4,$uidmaterial);
			  $insert->bindParam(5,$cantidad);
			  $insert->execute();
			   }
			   $sql=$dbh->prepare("select *from proyecto_material where IDproyecto=?");
			   $sql->bindParam(1,$uidproyecto);
			   $sql->execute();
			   if($sql->rowCount()>0){
				   echo "Materiales incorporados";
				   ?>
                   <img src="yes.jpg" height="20" width="20">
                   <?php
				   }else{
					   echo "No se pudieron incorporar los materiales";
					   ?>
                       <img src="no.jpg" height="20" width="20">
                       <?php
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
