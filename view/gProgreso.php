<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
	    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#00F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
	   </style>
 <link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
 <link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript">//inclusión del archivo jquery</script>
 <script src="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js" type="text/javascript">//inclusión del archivo jquery datepicker para el calendario</script>
 <script type="text/javascript" src="../js/ajaxgr.js">//incluye el archivo ajax para enviar a funciones de generación de ventanas modales</script>

</head>
<body>
<?php
if(isset($_SESSION["username"])){//valida la existencia de la sesión
	require_once("../db/connect.php");
	$idproyecto=$_POST["proyecto"];
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		$idopcion=$_POST["idopcion"];
		?>
<img src="../images/curva.jpg" height="40" width="40"><br>
<input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back()" id="button"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Seleccione un rango de fechas para realizar la impresión del gráfico correspondiente">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php 
	$sql=$dbh->prepare("select *from proyecto where IDproyecto=?");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	?>
<fieldset>
    <legend>FORMULARIO DE GASTO POR FASES</legend>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Selecciona la fase</label></td><td><select name="idfase" id="idfase">
    <?php
    $query=$dbh->prepare("select IDfase,nombre from fase where IDproyecto=? order by nombre asc");
	$query->bindParam(1,$idproyecto);
	$query->execute();
	if($query->rowCount()>0){
		foreach($query->fetchAll() as $fila){
			?>
            <option value="<?php echo $fila[0];?>"><?php echo $fila[1];//el dropdown despliega el nombre de la fase y la captura se realiza por su Identificador?>
            <?php
			}
		}
	?>
    </select></td></tr></div>
    <div><tr><td><label>Fecha Inicio</label></td><td><input type="text" id="fec1" class="fec1"></td></tr></div>
    <div><tr><td><label>Fecha Límite</label></td><td><input type="text" id="fec2" class="fec2"></td></tr></div>
  <tr><td><input type="button" class="boton_envio" id="sub" value="IMPRIMIR" onclick="grGastoCurva()"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
<script type="text/javascript">
$(function() {
	$( "#fec1" ).datepicker(); 
	$( "#fec1" ).datepicker('option',{dateFormat:'yy-mm-dd'});
	$( "#fec2" ).datepicker(); 
	$( "#fec2" ).datepicker('option',{dateFormat:'yy-mm-dd'});
});
    </script>
</body>
</html>