<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmaterial"])){
		//registro de la cantidad de items que corresponden a un equipo de maquinaria
		try{
		require_once("../../db/connect.php");
		$idmaterial=$_POST["IDmaterial"];
		$descItem=$_POST["DescItem"];
		$estado=$_POST["Estado"];
		
		$sql=$dbh->prepare("insert into item_material values(null,?,?,?,curdate(),curtime())");
		$sql->bindParam(1,$idmaterial);
		$sql->bindParam(2,$descItem);
		$sql->bindParam(3,$estado);
		if($sql->execute()){
			echo "Item registrado";
		$update=$dbh->prepare("update material set cant_disponible=cant_disponible+1 where IDmaterial=?");
		$update->bindParam(1,$idmaterial);
		$update->execute();
			?>
           <img src="yes.jpg" height="25" width="25">
            <?php	
			}else{
			echo "No se pudo registrar el item";
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