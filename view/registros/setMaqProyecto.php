<?php
session_start();
?>
<html>
<meta charset="utf-8">
<?php
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproyecto"])){
		require_once("../../db/connect.php");
		require_once("insertItemMaq.php");
		try{ 
		$IDmaquinaria=$_POST["IDmaquinaria"];
		$IDsolicitud=$_POST["IDsolicitud"];
		$IDproyecto=$_POST["IDproyecto"];
				//captura del precio unitario
			$consulta1=$dbh->prepare("select precio_elemental from maquinaria where IDmaquinaria=?");
			$consulta1->bindParam(1,$IDmaquinaria);
			$consulta1->execute();
			$result=$consulta1->fetch();
			$precio=$result["precio_elemental"];
				//captura de la cantidad solicitada
		$consulta=$dbh->prepare("select cantidad_sol from solicitud_maquinaria where IDsolicitud=?");
		$consulta->bindParam(1,$IDsolicitud);
		$consulta->execute();
	    $res=$consulta->fetch();
		$cant_sol=$res[0];
		//captura de la fecha de culiminación del proyecto
		$query=$dbh->prepare("select fecFinal from proyecto where IDproyecto=?");
		$query->bindParam(1,$IDproyecto);
		$query->execute();
		$row=$query->fetch();
		$fecFinal=$row["fecFinal"];
		//fecha de plazo de 10 días para devolver la maquinaria alquilada
		$fechaDevolucion= strtotime ( '+10 day' , strtotime ($fecFinal));
		$fechaDevolucion= date ( 'Y-m-d' , $fechaDevolucion );
		//cálculo de valor total
		$subtotal=0;
		$subtotal=$precio*$cant_sol;
		$iva=$subtotal*0.13;
		$total=$subtotal-$iva;
		
		$update=$dbh->prepare("update solicitud_maquinaria set subtotal=?, iva=?, total=?, compromiso_alquiler='si',estado='Atendido', fecha_devolucion=? where IDsolicitud=? and IDmaquinaria=?");
		$update->bindParam(1,$subtotal);
		$update->bindParam(2,$iva);
		$update->bindParam(3,$total);
		$update->bindParam(4,$fechaDevolucion);
		$update->bindParam(5,$IDsolicitud);
		$update->bindParam(6,$IDmaquinaria);
		$update->execute();
		
		$updateMaq=$dbh->prepare("update maquinaria set cantidad_disponible=? where IDmaquinaria=?");
		$updateMaq->bindParam(1,$cant_sol);
		$updateMaq->bindParam(2,$IDmaquinaria);
		if($updateMaq->execute()){
			//insertItemMaq($cant_sol,$IDmaquinaria);
			echo "Solicitud procesada";
			?>
            <img src="yes.jpg" height="25" width="25">
            <?php
			}else{
				echo "No se pudo actualizar la solicitud";
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