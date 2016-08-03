<?php session_start();//función de inicio de sesión?>
<meta charset="utf-8">
<?php
#Este programa se encarga de registrar cotizaciones de materiales
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
if(isset($_POST["Nro"])){//verifica la existencia del nro de cotización
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	$nro=$_POST["Nro"];
	$nroSol=$_POST["NroSol"];
	//consulta existencia del detalle
	$consulta=$dbh->prepare("SELECT *FROM det_cotizacion, cotizacion
                             WHERE cotizacion.nro_cotizacion = det_cotizacion.nro_cotizacion
                             AND cotizacion.nro_solicitud = ?");
	$consulta->bindParam(1,$nroSol);
	$consulta->execute();
	if($consulta->rowCount()>0){
		echo "La cotización ya cuenta con su detalle registrado<br>";
		echo "Presione el botón consultar";
		?>
        <img src="yes.jpg" height="25" width="25">
        <?php
		}else{
	#consulta la cantidad solicitad solicitada de material en base a solicitudes de cotización
	$sql=$dbh->prepare("SELECT m.IDmaterial,cantidad_sol, d.unidad, precio_bs
                        FROM material AS m, det_solicitud_cotizacion AS d
                        WHERE m.IDmaterial = d.IDmaterial
                        AND d.nro_solicitud = ?");
	$sql->bindParam(1,$nroSol);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $row){//arreglo que recorrerá las filas del registro
			$idmaterial=$row[0];//almacena el id de material
			$cant=$row[1];//almacena la cantidad
			$unidad=$row[2];//almacena la unidad
			$precio=$row[3];//almacena el precio
			$subtotal=$cant*$precio;//calcula el subtotal
			#dentro del arreglo se procede a realizar el registro de detalles de cotización
			$insert=$dbh->prepare("insert into det_cotizacion values(?,?,?,?,?,?)");
			$insert->bindParam(1,$nro);//enlaza al nro de cotización
			$insert->bindParam(2,$idmaterial);//enlaza al id de material
			$insert->bindParam(3,$cant);//enlaza a la cantidad
			$insert->bindParam(4,$unidad);//enlaza a la unidad
			$insert->bindParam(5,$precio);//enlaza al precio
			$insert->bindParam(6,$subtotal);//enlaza al subtotal
			$insert->execute();
			}
			#consulta de confirmación del registro
		 $reg=$dbh->prepare("select *from det_cotizacion where nro_cotizacion=?");
	$reg->bindParam(1,$nro);
	$reg->execute();
	if($reg->rowCount()>0){
		echo "Detalle de cotización registrado";
		?>
        <img src="yes.jpg" height="25" width="25">
        <?php
		}  else{
			echo "No se pudo registrar el detalle de cotización";
			}
		}else{
			echo "No se encontró el detalle para la cotización";
			?>
            <img src="no.jpg" height="25" width="25">
            <?php
			}
		}
}else{
	header("location: ../../index.php");//redirige al login
	}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>