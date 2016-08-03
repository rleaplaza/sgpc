<?php session_start();//función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Información de la fase</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../js/ajaxgr.js"></script>

 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
  #sub{font-wight:bold;
	   cursor:pointer;
	   padding:5px;
	   color:#FFF;
	   margin: 0 10px 20 px 0;
	   border: 1px solid #ccc;
	   background:#00F;
	   border-radius:8px 8px 8px 8px;
	  }
 #sub:hover{
	   background:#06F;
	   color:#FFF;
	 }
  table{
        border-radius:10px;
	    box-shadow:0px 0px 13px  rgba(0,0,0,0.5);
		-web-kit-box-shadow:0px 0px 13px rbga(0,0,0,0.5);
		}
 table th{
		border-radius:5px;
		border:1px;
		background:rgba(189,184,121,0.2);
		}
  table td{
	border-radius:5px;
	border:1px;
	background:rgba(143,184,121,0.1);			
	}
	.image{
		float:left;
		}
	   </style>
</head>

<body>
<?php
#Este programa realiza el despliegue de la información de un determinada actividad y las opciones para imprimir gráficos sobre costo, duración, recursos utilizados y avances por trabajador
if(isset($_SESSION["username"])){#valida la sesión
	if(isset($_POST["idfase"])){//valida la existencia de la actividad
	require_once("../db/connect.php");//archivo de conexión global a la BD
	$user=$_SESSION["username"];
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);
	$consulta->execute();
	if($consulta->rowCount()>0){//si existe el resultado ejecuta las instrucciones
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		?>
        <img src="../images/planificacion.png" height="80" width="80"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para realizar impresiones de reportes gráficos debe seleccionar el tipo de gráfico y enviar a la impresión mediante los botones">
        <form method="post">
        <input type="hidden" name="idopcion" value="<?php echo $_POST["idopcion"];?>">
        <input type="hidden" name="idfase" value="<?php echo $_POST["idfase"];?>">
        <input type="hidden" name="proyecto" value="<?php echo $_POST["proyecto"];?>">
        <input type="submit" value="Volver al formulario" onClick="this.form.action='controlFase.php'" id="sub">
        </form>
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
	#captura de variables, ejecución de la consulta según el ID del proyecto
    $UIDfase=$_POST["idfase"];
	$sql=$dbh->prepare("select *from fase where IDfase=?");
	$sql->bindParam(1,$UIDfase);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		//asignación de variables de arreglo
		$fase=$row["nombre"];
		$long=$row["longitudKM"];
		$estado=$row["estado"];
		$actProgramadas=$row["act_programadas"];
		$actConcluidas=$row["act_concluidas"];
		if($actProgramadas>0){
		$progreso=($actConcluidas/$actProgramadas)*100;
		}else{
			$progreso=0;
			}
	?>
    <fieldset>
    <legend>INFORMACIÓN DE LA FASE</legend>
    <table align="left" border="1" bordercolor="#0066FF" bordercolorlight="#0033FF" width="1000">
    <th><a href="<?php echo "../reportes/proyectos/infoFase.php?proyecto=".$_POST["nombreproyecto"]."&idfase=".$UIDfase."&user=".$user;?>"><img src="../images/pdf_1.jpg" height="20" width="20" title="Imprimir en PDF" class="image"></a><label>Referencia</label></th><th></th>
     <input type="hidden" value="<?php echo $UIDfase;?>" id="idfase">
     <input type="hidden" value="<?php echo $fase;?>" id="fase">
     <input type="hidden" value="<?php echo $long;?>" id="long">
     <input type="hidden" value="<?php echo $estado;?>" id="estado">
     <input type="hidden" value="<?php echo $actProgramadas;?>" id="actpr">
     <input type="hidden" value="<?php echo $actConcluidas;?>" id="actcon">
     <input type="hidden" value="<?php echo $progreso=round($progreso,2);?>" id="progreso">
     <input type="hidden" value="<?php echo $_POST["nombreproyecto"];?>" id="proyecto">
      <tr><td><label>Proyecto</label></td><td><?php echo $_POST["nombreproyecto"];?></td></tr>
      <tr><td><label>Fase</label></td><td><?php echo $fase;?></td></tr>
      <tr><td><label>Longitud</label></td><td><?php echo $long." Km";?></td></tr>
      <tr><td><label>Estado</label></td><td><?php echo $estado;?></td></tr>
      <tr><td><label>Actividades programadas</label></td><td><?php echo $actProgramadas;?></td></tr>
      <tr><td><label>Actividades concluidas</label></td><td><?php echo $actConcluidas;?></td></tr>
       <tr><td><label>Progreso</label></td><td><?php echo $progreso." %";?></td></tr>
      <tr><td><label>Tipo de gráfico a imprimir</label></td><td><select name="tipo" id="tipo">
                                                                <option value="">_tipo de gráfico
                                                                <option value="barra">Barra
                                                                <option value="torta">Torta
                                                                </select>
      </td></tr>
 <tr><td><fieldset>
 <legend>Informes</legend>
          <button onclick="sendProgFase()" id="sub">Progreso</button>
          <button onclick="gantt()" id="sub">Diagrama de gantt</button>
          </fieldset></td></tr>
          
    </table>
    </fieldset>
    <?php
	}else{
		echo "Sin resultados para mostrar";//mensaje de no existencia de registros
		}
	}else{
		header("location: ../index.php");//direge al login en caso de no existir la variable id de actividad
		}
	}else{
		header("location: ../index.php");//direge al login en caso de no existir la sesión
		}
?>
</body>
</html>