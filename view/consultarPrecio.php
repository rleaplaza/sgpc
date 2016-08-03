<?php session_start();//función de inicio de sesión
#Este programa se encarga de desplegar el detalle del precio unitario de una actividad específica?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js">//llama al archivo jquery</script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js">//archivo jquery ui</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){//valida si la sesión existe
	try{//inicia el try catch para operar la instrucción y generar exepciones
	require_once("../db/connect.php");//archivo de conexión a la base de datos
	#captura el id de actividad
    $idactividad=$_GET["idactividad"];
	#consulta para despliegue del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);//enlaza al id de la opción
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_POST["idopcion"];
		$row=$consulta->fetch();
		echo("<label>".$row["nombremenu"]."</label> ");
		echo("<label>". $row["nombresubmenu"]."</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		}
		else{
			header("location: ../index.php");
			}
	}
?>
<style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  text-align:center;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
				 td{
					 background:#CCC;
				 }
				 .table{
					 border-radius:2px 2px 2px 2px;
					 box-shadow:2px 2px 2px 2px;
					 	-web-kit-box-shadow:0px 0px 13px rbga(0,0,0,0.5);
					 }
				 
			</style>
      <h2><legend>ANÁLISIS DE PRECIOS UNITARIOS</legend></h2>
        <img src="../images/precios.jpg" width="30" height="30" />
        <a href="<?php echo "../reportes/proyectos/informePrecio.php?idactividad=$idactividad";?>"><img src="../images/pdf.jpg" width="30" height="30" title="Imprimir informe en PDF"></a><br>
       <table width="437" align="left" class="table">
<?php

#Consulta para recuperar el detalle del precio unitario de la actividad
	$sql=$dbh->prepare("SELECT IDactividad, nombreActividad, t_actmaterial, t_acmanoobra, t_acmaquinaria, t_gastoadm, t_utilidad, t_impuesto, unidades, cantidad, total_avance, precioUnitarioBS, costo_total
                        FROM actividad
                        WHERE IDactividad=?
						order by hraRegistro");
	$sql->bindParam(1,$idactividad);//enlaza el id de la actividad
	$sql->execute();//ejecuta la instrucción
	$dbh->query("SET NAMES UTF8");//habilita la codificación utf8
	$row=$sql->fetch();
	?>
     <tr><td width="160"><label>Actividad</label></td><td width="659"><?php echo $row[1];?></td></tr>
     <tr><td><label>Total por material</label></td><td><?php echo $row[2]." Bs";?></td></tr>
     <tr><td><label>Total por mano de obra</label></td><td><?php echo $row[3]." Bs";?></td></tr>
     <tr><td><label>Total por maquinaria</label></td><td><?php echo $row[4]." Bs";?></td></tr>
     <tr><td><label>Gasto administrativo</label></td><td><?php echo $row[5]." Bs";?></td></tr>
     <tr><td><label>Utilidad</label></td><td><?php echo $row[6]." Bs";?></td></tr>
     <tr><td><label>Impuesto</label></td><td><?php echo $row[7]." Bs";?></td></tr>
     <tr><td><label>Cantidad</label></td><td><?php echo $row[9]." ".$row[8];?></td></tr>
     <tr><td><label>Precio unitario</label></td><td><?php echo $row[11]." Bs";?></td></tr>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");//devuelve al login en caso de que no se cumpla con el requisito de acceso como variables
	}
?>
</body>
</html>