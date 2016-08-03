<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");
		$nro=$_POST["Nro"];
		$idproy=$_POST["IDproyecto"];
		$fecha=$_POST["Fecha"];
		$idequipamiento=$_POST["IDequipamiento"];
		$cantidad=$_POST["Cantidad"];
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad))){
			echo "El valor de la cantidad debe ser numérico";
		}else{
		$sql=$dbh->prepare("select *from req_equipamiento where nro_requerimiento=?");
		$sql->bindParam(1,$nro);
		$sql->execute();
		$desc="Requerimiento de equipamiento";
		if($sql->rowCount()==0){
			$insert=$dbh->prepare("insert into req_equipamiento values(?,?,?,?,curtime())");
			$insert->bindParam(1,$nro);
			$insert->bindParam(2,$idproy);
			$insert->bindParam(3,$desc);
			$insert->bindParam(4,$fecha);
			$insert->execute();
			}
		$sql=$dbh->prepare("select *from det_req_equipamiento where IDmaquinaria=? and nro_requerimiento=?");
		$sql->bindParam(1,$idequipamiento);
		$sql->bindParam(2,$nro);
		$sql->execute();
		if($sql->rowCount()>0){
			$update=$dbh->prepare("update det_req_equipamiento set cantidad=cantidad+? where IDmaquinaria=? and nro_requerimiento=?");
			$update->bindParam(1,$cantidad);
			$update->bindParam(2,$idequipamiento);
			$update->bindParam(3,$nro);
			if($update->execute()){
				echo "Cantidad actualizada";
				?>
                <img src="yes.jpg" height="20" width="20">
                <?php
				}
			}else{
				$query=$dbh->prepare("insert into det_req_equipamiento values(?,?,?)");
				$query->bindParam(1,$nro);
				$query->bindParam(2,$idequipamiento);
				$query->bindParam(3,$cantidad);
				if($query->execute()){
					echo "Equipamiento registrado en requerimiento";
					?>
                    <img src="yes.jpg" height="20" width="20">
                    <?php
					}else{
					echo "No se pudo registrar el equipamiento requerido";
					?>
                    <img src="no.jpg" height="20" width="20">
                    <?php	
						}
				}
		}
		
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>