<?php session_start();?>
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");
		$nro=$_POST["Nro"];
		$idproy=$_POST["IDproyecto"];
		$fecha=$_POST["Fecha"];
		$idmaterial=$_POST["IDmaterial"];
		$cantidad=$_POST["Cantidad"];
		if(!(preg_match('/^[0-9]+(\.[0-9]+)?$/',$cantidad))){
			echo "El valor de la cantidad debe ser numérico";
		}else{
		$sql=$dbh->prepare("select *from req_material where nro_requerimiento=?");
		$sql->bindParam(1,$nro);
		$sql->execute();
		$desc="Requerimiento de materiales";
		if($sql->rowCount()==0){
			$insert=$dbh->prepare("insert into req_material values(?,?,?,?,curtime())");
			$insert->bindParam(1,$nro);
			$insert->bindParam(2,$idproy);
			$insert->bindParam(3,$desc);
			$insert->bindParam(4,$fecha);
			$insert->execute();
			}
		$sql=$dbh->prepare("select *from det_req_material where IDmaterial=? and nro_requerimiento=?");
		$sql->bindParam(1,$idmaterial);
		$sql->bindParam(2,$nro);
		$sql->execute();
		if($sql->rowCount()>0){
			$update=$dbh->prepare("update det_req_material set cantidad=cantidad+? where IDmaterial=? and nro_requerimiento=?");
			$update->bindParam(1,$cantidad);
			$update->bindParam(2,$idmaterial);
			$update->bindParam(3,$nro);
			if($update->execute()){
				echo "Cantidad actualizada";
				?>
                <img src="yes.jpg" height="20" width="20">
                <?php
				}
			}else{
				$consulta=$dbh->prepare("select unidad from material where IDmaterial=?");
				$consulta->bindParam(1,$idmaterial);
				$consulta->execute();
				if($consulta->rowCount()>0){
					$fila=$consulta->fetch();
					$unidad=$fila[0];
					}
				$query=$dbh->prepare("insert into det_req_material values(?,?,?,?)");
				$query->bindParam(1,$nro);
				$query->bindParam(2,$idmaterial);
				$query->bindParam(3,$cantidad);
				$query->bindParam(4,$unidad);
				if($query->execute()){
					echo "Material registrado en requerimiento";
					?>
                    <img src="yes.jpg" height="20" width="20">
                    <?php
					}else{
					echo "No se pudo registrar el material requerido";
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