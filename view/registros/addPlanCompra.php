<?php session_start();//funcion de inicio de sesion?>
<meta charset="utf-8">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	   </style>
<?php
if(isset($_SESSION["username"])){//verifia la existencia de la sesion
	if(isset($_POST["Item"])){
		require_once("../../db/connect.php");//llama a la conexion a base de datos
		require_once("generaNumero.php");//llama al archivo de generacion de identificador
		try{
			$idplan=generaNumero();//funcion de generacion de numeros
			$uidproyecto=$_POST["IDproyecto"];
			$desc=$_POST["Desc"];
			$item=$_POST["Item"];
			$cant=$_POST["Cantidad"];
			$fec1=$_POST["Fec1"];
		if(!(preg_match('/(\d{4})-(\d{2})-(\d{2})/',$fec1))){//expresion regular para evaluar el formato de fechas
			echo "Formato de fecha incorrecto";
		}else{#consulta que impide registrar planes de compra en dias feriados
			$consulta=$dbh->prepare("select nombre, Inicio_feriado, Fin_feriado from calendario_feriado
			                         where Inicio_feriado=? or Fin_feriado=?");
			$consulta->bindParam(1,$fec1);
			$consulta->bindParam(2,$fec1);
			$consulta->execute();
			if($consulta->rowCount()>0){
				$result=$consulta->fetch();
				echo "La fecha introducida corresponde al feriado: ".$result["nombre"];
				?>
                <img scr="no.jpg" height="25" width="25">
                <?php
				}else{
					#consulta de registro de planificacion de compras
				$sql=$dbh->prepare("insert into planificacion_compra values(?,?,?,?,?,?,null)");
				$sql->bindParam(1,$idplan);
				$sql->bindParam(2,$uidproyecto);
				$sql->bindParam(3,$desc);
				$sql->bindParam(4,$item);
				$sql->bindParam(5,$cant);
				$sql->bindParam(6,$fec1);
				if($sql->execute()){
					echo "Planificación registrada<br>";
					echo "<label>Nro de plan generado </label>".$idplan;
					?>
                   <img src="yes.jpg" height="25" width="25"> 
                    <?php
					}else{
						echo "No se pudo registrar la planificación";
						?>
                        <img src="no.jpg" height="25" width="25">
                        <?php
						}
				}
		}
			}catch(PDOException $e){
				echo "Error inesperado";//genera la exepcion
				}
		}else{
			header("location: ../../index.php");//redirige al login
			}
	}else{
		header("location: ../../index.php");//redirige al login
		}
?>