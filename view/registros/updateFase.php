<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	function updateFase($IDfase){
		global $dbh;
	try{
		$sql=$dbh->prepare("update fase set act_concluidas=act_concluidas+1 where IDfase=?");
		$sql->bindParam(1,$IDfase);
		$sql->execute();
		$consulta=$dbh->prepare("select act_programadas, act_concluidas from fase where IDfase=?");
		$consulta->bindParam(1,$IDfase);
		$consulta->execute();
		if($consulta->rowCount()>0){
			$row=$consulta->fetch();
			$actProgramadas=$row[0];
			$actConcluidas=$row[1];
			if($actConcluidas==$actProgramadas){
				$query=$dbh->prepare("update fase set estado='finalizada' where IDfase=?");
				$query->bindParam(1,$IDfase);
				if($query->execute()){
					echo "Fase finalizada"
					?>
                    <img src="yes.jpg" height="25" width="25">
                    <?php
					}else{
					 echo "Error al finalizar la fase";
						?>
                     <img src="no.jpg" height="25" width="25">
                        <?php
						}
				}
			}
		}catch(PDOException $e){
			echo "Error inesperado ".$e->getMessage();
			}
	}
	function updateActFase($IDfase){
		global $dbh;
		try{
		
		$sql=$dbh->prepare("update fase set act_programadas=act_programadas+1 where IDfase=?");
		$sql->bindParam(1,$IDfase);
		$sql->execute();
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		}
	}else{
		header("location: ../../index.php");
		}
?>