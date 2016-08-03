<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nombre"])){
		require_once("../../db/connect.php");
		require_once("genera.php");
		try{
			$idferiado=$_POST["IDferiado"];
			$nombre=$_POST["Nombre"];
			$desc=$_POST["Desc"];
			$fec1=$_POST["Fec1"];
			$fec2=$_POST["Fec2"];
			if(is_null($nombre) || is_null($desc) || is_null($fec1) || is_null($fec2)){
				echo "Complete todos los campos";
			}else{
			if(!(preg_match('/(\d{4})-(\d{2})-(\d{2})?$/',$fec2))){
				echo "Fecha incorrecta";
				?>
                <img src="no.jpg" height="25" width="25">
                <?php
				}else{
					if($fec1>$fec2){
					echo "La fecha de inicio no puede ser mayor que la fecha de fin";	
					?>
                    <img src="no.jpg" height="25" width="25">
                    <?php
						}else{
$sql=$dbh->prepare("update calendario_feriado set nombre=?, descripcion=?, Inicio_feriado=?, Fin_feriado=? where IDferiado=?");
			 $sql->bindParam(1,$nombre);
			 $sql->bindParam(2,$desc);
			 $sql->bindParam(3,$fec1);
			 $sql->bindParam(4,$fec2);
			 $sql->bindParam(5,$idferiado);
			 if($sql->execute()){
				 echo "Feriado actualizado";
				 ?>
                 <img src="yes.jpg" height="25" width="25">
                 <?php
				 }else{
				echo "No se pudo actualizar el feriado";
				?>
                  <img src="no.jpg" height="25" width="25">
                <?php	 
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