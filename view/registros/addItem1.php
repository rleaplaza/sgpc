<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDmaquinaria"])){
		//registro de la cantidad de items que corresponden a un equipo de maquinaria
		try{
		require_once("../../db/connect.php");
		$idmaquinaria=$_POST["IDmaquinaria"];
		$descItem=$_POST["DescItem"];
		$estado=$_POST["Estado"];
		
		$sql=$dbh->prepare("insert into item_maquinaria values(null,?,?,?,curdate(),curtime())");
		$sql->bindParam(1,$idmaquinaria);
		$sql->bindParam(2,$descItem);
		$sql->bindParam(3,$estado);
		if($sql->execute()){
			echo "Item registrado";
		$update=$dbh->prepare("update maquinaria set cantidad_disponible=cantidad_disponible+1 where IDmaquinaria=?");
		$update->bindParam(1,$idmaquinaria);
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