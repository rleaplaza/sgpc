<?php session_start();//función de inicio de sesión
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" rel="stylesheet" type="text/css">
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	          color:#009;
	           size:auto;
				 }
				  #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
	     #button:hover{
			background:#ddd;
			}
			</style>
</head>


<body>
<img src="../images/empleado.jpg" width="50" height="50" />
<legend>Información Laboral de empleado</legend>
<input type="submit" value='Volver a listado de empleados' onClick='history.back();' id="button">
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	require_once("../../db/connect.php");//llama a la conexión a base de datos
	try{//consulta de la información laboral del empleado
    $sql=$dbh->prepare("SELECT empleado.nombres, app, apm, fecIngreso, cargo.nombre, departamento.nombre, haberBasico,aniosTrabajo from empleado, cargo,       departamento
	 where empleado.IDcargo=cargo.IDcargo
	 and empleado.IDdepto=departamento.IDdepto
	 and CI=?");
	$sql->bindParam(1,$_GET["cedula"]);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		?>
            <form method="post" class="usuario" id="formualrio" >
            <table>
 <div><tr><td><label>Nombre completo:</label></td><td><input type="text" class="fecha" name="fecha" value="<?php echo $row[0]." ".$row[1]." ".$row[2];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Fecha de ingreso a la empresa:</label></td><td><input type="text" class="cargo" name="cargo" value="<?php echo $row[3];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Cargo:</label></td><td><input type="text" class="depto" name="depto" value="<?php echo $row[4];?>" disabled="disabled"></td></tr></div>
 <div><tr><td><label>Departamento:</label></td><td><input type="text" class="salario" name="salario" value="<?php echo $row[5];?>" disabled="disabled"></td></tr></div>
 <div> <tr><td><label>Haber basico:</label></td><td><input type="text" class="horario" name="horario" value="<?php echo $row[6];?>" disabled="disabled"></td></tr></div>
  <div><tr><td><label>Años en la empresa:</label></td><td><input type="text" class="bono" name="bono" value="<?php echo $row[7];?>" disabled="disabled"></td></tr></div>
 </table>
                </form>
       <?php
		}else{
			echo "<label>Su informacion aun no esta en sistema, consulte al administrador general de la empresa</label>";
			}
		}catch(PDOException $e){
		 echo("Error inesperado".$e->getMessage());
			}
	    }else{
		header("location: ../../index.php");
		}
?>
</div>
</body>
</html>