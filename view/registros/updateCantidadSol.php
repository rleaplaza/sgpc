<?php session_start();//inicio de sesion?>
<?php
if(isset($_SESSION["username"])){//valida la existencia de sesion
	if(isset($_POST["Nro"])){
		require_once("../../db/connect.php");//llama a la conexion global
		try{#captura de variables
			$nro=$_POST["Nro"];
			$idmat=$_POST["IDmat"];
			$unidad=$_POST["Unidad"];
			$cant=$_POST["Cantidad"];
			#consulta del detalle de solicitud de cotizacion
			$consulta=$dbh->prepare("select *from det_solicitud_cotizacion where nro_solicitud=? and IDmaterial=?");
			$consulta->bindParam(1,$nro);
			$consulta->bindParam(2,$idmat);
			$consulta->execute();
			if($consulta->rowCount()>0){
				echo "Material ya registrado en la solicitud de cotización<br>";
				#actualiza el detalle en base al material seleccionado en caso de que exista en sistema
				$update=$dbh->prepare("update det_solicitud_cotizacion set cantidad_sol=? where nro_solicitud=? and                                      IDmaterial=?");
				$update->bindParam(1,$cant);
				$update->bindParam(2,$nro);
				$update->bindParam(3,$idmat);
				if($update->execute()){
				echo "Cantidad actualizada";
				?>
                <img src="yes.jpg" height="25" width="25">
                <?php
				}
				}
			}catch(PDOException $e){
				echo "Error inesperado".$e->getMessage();//genera la exepcion
				}
		}else{
			header("location: ../../index.php");
			}//redirige al login
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>