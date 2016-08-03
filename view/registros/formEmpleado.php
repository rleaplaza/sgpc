<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
        <style>
       label{ font:Verdana, Geneva, sans-serif;
        color:#00C;
	         }
	   legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
	   #sub{
	   font-wight:bold;
	   cursor:pointer;
	   padding:5px;
	   margin: 0 10px 20 px 0;
	   border: 1px solid #ccc;
	   background:#eee;
	   border-radius:8px 8px 8px 8px;
		}
		#sub:hover{
		background:#ddd;
		}
	    </style>
     <link href="../../css/estilos.css" rel="stylesheet" type="text/css">
     <link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
     <link href="../../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
     <script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
  

</head>

<body>
<img src="../../images/empleado.jpg" height="30" width="30"/>
<legend>INFORMACIÓN DEL EMPLEADO</legend><br>
<input type="submit" value="Volver al listado anterior" onClick='history.back();' id="sub">
<?php
if(isset($_SESSION["username"])){
	require_once("../../db/connect.php");
	try{ 
	$usrUID=$_GET["id"];
	$sql=$dbh->prepare("SELECT usuario.USR_UID,usuario.nombre, app,apm, fecIngreso, cargo.nombre AS cargo, departamento.nombre AS departamento,                        haberBasico, hraIngreso, bono, totalGanado, descuentos, liquidoPagable, fechaRegistro, hraRegistro
                       FROM usuario, empleado, cargo, departamento
                       WHERE usuario.USR_UID = empleado.USR_UID
                       AND empleado.IDcargo = cargo.IDcargo
                       AND empleado.IDdepto = departamento.IDdepto
					   AND usuario.USR_UID=?");
	$sql->bindParam(1,$usrUID);
    $sql->execute();
    if($sql->rowCount()>0){
	foreach($sql->fetchAll() as $row){
	?>
     <fieldset>
     <form method="post" name="form1" class="usuario" id="formulario">
     <table>
   <div><tr><td><label>USER ID</label></td><td><input type="text" name="userid" disabled="disabled" value="<?php echo $row[0];?>"></td></tr></div>
   <div><tr><td><label>NOMBRE</label></td><td><input type="text" name="nombre" disabled="disabled" value="<?php echo $row[1];?>"></td></tr></div>
   <div><tr><td><label>APELLIDOS</label></td><td><input type="text" name="apellidos" disabled="disabled" value="<?php echo $row[2]." ".$row[3];?>"></td></tr></div>
   <div><tr><td><label>FECHA DE INGRESO</label></td><td><input type="text" name="fecIngreso" disabled="diabled" value="<?php echo $row[4];?>"></td></tr></div>
   <div><tr><td><label>CARGO</label></td><td><input type="text" name="cargo" disabled="disabled" value="<?php echo $row[5];?>"></td></tr></div>
   <div><tr><td><label>DEPARTAMENTO</label></td><td><input type="text" name="depto" disabled="disabled" value="<?php echo $row[6];?>"></td></tr></div>
   <div><tr><td><label>HABER BASICO</label></td><td><input type="text" name="salario" class="salario" value="<?php echo $row[7];?>"><img src="editable.jpg" height="20" width="20"/></td></tr></div>
   <div><tr><td><label>HORA DE ENTRADA</label></td><td><input type="text" name="hra" disabled="disabled" value="<?php echo $row[8];?>"></td></tr></div>
   <div><tr><td><label>BONO</label></td><td><input type="text" name="bono" disabled="disabled" value="<?php echo $row[9];?>"></td></tr></div>
   <div><tr><td><label>TOTAL GANADO</label></td><td><input type="text" name="total" disabled="disabled" value="<?php echo $row[10];?>"></td></tr></div>
   <div><tr><td><label>DESCUENTO POR AFP</label></td><td><input type="text" name="afp" disabled="disabled" value="<?php echo $row[11];?>"></td></tr></div>
   <div><tr><td><label>LÍQUIDO PAGABLE</label></td><td><input type="text" name="liquido" disabled="disabled" value="<?php echo $row[12];?>"></td></tr></div>
   <div><tr><td><label>FECHA DE REGISTRO</label></td><td><input type="text" name="fecR" disabled="disabled" value="<?php echo $row[13];?>"></td></tr></div>
   <div><tr><td><label>HORA DE REGISTRO</label></td><td><input type="text" name="hraR" disabled="disabled" value="<?php echo $row[14];?>"></td></tr></div>
   <input type="hidden" name="userId" class="userId" value="<?php echo $row[0];?>">
         <div class="ultimo">
  <img src="../../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
   <tr><td><button id="button" class="boton_envio">ACTUALIZAR REGISTRO</button></td></tr>
   </div>
    </table>
    </form>
    </fieldset>
      <script src="../../js/updateEmpleado.js"></script>

                <?php
				}
			}
		
		
		}catch(PDOException $e){
			echo("Error inesperado".$e->getMessage());
			}
}else{
	 header("location: ../../index.php");
		}
?>
</body>
</html>