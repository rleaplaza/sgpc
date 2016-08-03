<?php session_start();//función de inicio de sesión?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Información de la actividad</title>
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
	if(isset($_POST["idactividad"])){//valida la existencia de la actividad
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
        <img src="../images/actividad.png" height="20" width="20"><br>
       
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para realizar impresiones de reportes gráficos debe seleccionar el tipo de gráfico y enviar a la impresión mediante los botones"><br>
        <form method="post">
        <input type="hidden" name="idopcion" value="<?php echo $_POST["idopcion"];?>">
        <input type="hidden" name="idactividad" value="<?php echo $_POST["idactividad"];?>">
        <input type="hidden" name="proyecto" value="<?php echo $_POST["proyecto"];?>">
        <input type="submit" value="Salir" onClick="this.form.action='listControl.php'" id="sub">
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
    $UIDactividad=$_POST["idactividad"];
	$sql=$dbh->prepare("select *from actividad where IDactividad=?");
	$sql->bindParam(1,$UIDactividad);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		#asignación de costos real y programado
		$costo_programado=$row["costo_programado"];
		$costo_real=$row["costo_total"];
		#asignación de avances
		$cantidad_programada=$row["cantidad"];
		$avance_real=$row["total_avance"];
		#almacena el porcentaje de progreso de la actividad
		$progreso=($avance_real*100)/$cantidad_programada;
		$progreso=round($progreso,2);
		$variacion=$cantidad_programada-$avance_real;
		$variacion_costo=$costo_programado-$costo_real;
		$unidades=$row["unidades"];
		$actividad=$row["nombreActividad"];
		$estado=$row["finalizado"];
	?>
    <fieldset>
    <legend>INFORMACIÓN DE LA ACTIVIDAD</legend>
    <table align="left" border="1" bordercolor="#0066FF" bordercolorlight="#0033FF">
    <th><a href="<?php echo "../reportes/proyectos/infoActividad.php?idactividad=".$UIDactividad."&user=".$user;?>"><img src="../images/pdf_1.jpg" height="20" width="20" title="Imprimir en PDF" class="image"></a><label>Referencia</label></th><th></th>
     <input type="hidden" value="<?php echo $UIDactividad;?>" id="idactividad">
     <input type="hidden" value="<?php echo $actividad;?>" id="actividad">
     <input type="hidden" value="<?php echo $cantidad_programada;?>" id="avanceprog">
     <input type="hidden" value="<?php echo $avance_real;?>" id="avancereal">
     <input type="hidden" value="<?php echo $progreso;?>" id="progreso">
     <input type="hidden" value="<?php echo $costo_programado;?>" id="costoprogramado">
     <input type="hidden" value="<?php echo $costo_real;?>" id="costoreal">
     <input type="hidden" value="<?php echo $progreso;?>" id="progreso">
     <input type="hidden" value="<?php echo $unidades;?>" id="unidades">
      <tr><td><label>Actividad</label></td><td><?php echo $actividad;?></td></tr>
      <tr><td><label>Fecha de inicio</label></td><td><?php echo $row["fechaRealizacion"];?></td></tr>
      <tr><td><label>Fecha de finalización</label></td><td><?php echo $row["fechaFin"];?></td></tr>
      <tr><td><label>Duración programada</label></td><td><?php echo $row["duracion_dias"]." dias";?></td></tr>
      <tr><td><label>Días utilizados</label></td><td><?php echo $row["dias_usados"]." dias";?></td></tr>
      <tr><td><label>Cantidad programada</label></td><td><?php echo $cantidad_programada." ".$unidades;?></td></tr>
      <tr><td><label>Avance real</label></td><td><?php echo $avance_real." ".$unidades;?></td></tr>
      <tr><td><label>Costo programado</label></td><td><?php echo $costo_programado. " Bs";?></td></tr>
      <tr><td><label>Costo real</label></td><td><?php echo $costo_real. " Bs";?></td></tr>
      <tr><td><label>Diferencia de costos</label></td><td><?php echo $variacion_costo." Bs";?></td></tr>
      <tr><td><label>Porcentaje de progreso</label></td><td><?php echo $progreso." %";?></td></tr>
      <tr><td><label>Estado</label></td><td><?php echo $estado;?></td></tr>
     
      <tr><td><label>Materiales utilizados</label></td><td><select name="idmaterial" id="idmaterial">
     <?php //consulta para mostrar el listado de materiales dentro de la actividad
	 $consulta=$dbh->prepare("select m.IDmaterial,m.descripcion from material as m, actividad as a, actividad_material as am
	                     where m.IDmaterial=am.IDmaterial
						 and am.IDactividad=a.IDactividad
						 and a.IDactividad=?");
	$consulta->bindParam(1,$UIDactividad);//enlaza al id de la actividad
	$consulta->execute();
	if($consulta->rowCount()>0){
		foreach($consulta->fetchAll() as $reg){//el arreglo desplegará el resultado
			?>
            <option value="<?php echo $reg[0];?>"><?php echo $reg[1];?>
            <?php
			}
		}else{//en caso de no existir materiales se mostrará el siguiente texto
			?>
            <option value="">_sin material programado
            <?php
			}
	 ?>
           </select>
  </td></tr>
  <tr><td><label>Equipamiento utilizado</label></td><td><select name="idequipamiento" id="idequipamiento">
     <?php //consulta para mostrar el listado de materiales dentro de la actividad
	 $consulta=$dbh->prepare("select m.IDmaquinaria,m.descripcion from maquinaria as m, actividad as a, actividad_maquinaria as am
	                     where m.IDmaquinaria=am.IDmaquinaria
						 and am.IDactividad=a.IDactividad
						 and a.IDactividad=?");
	$consulta->bindParam(1,$UIDactividad);//enlaza al id de la actividad
	$consulta->execute();
	if($consulta->rowCount()>0){
		foreach($consulta->fetchAll() as $fila){//el arreglo desplegará el resultado
			?>
            <option value="<?php echo $fila[0];?>"><?php echo $fila[1];?>
            <?php
			}
		}else{//en caso de no existir materiales se mostrará el siguiente texto
			?>
            <option value="">_sin equipamiento programado
            <?php
			}
	 ?>
           </select>
  </td></tr>
   <tr><td><label>Tipo de gráfico a imprimir</label></td><td><select name="tipo" id="tipo">
                                                                <option value="">_seleccione un tipo de gráfico
                                                                <option value="barra">Barra
                                                                <option value="torta">Torta
                                                                </select>
      </td></tr>
  <tr><td><button onclick="sendGrcostoAc()" id="sub">Costo real y programado</button>
          <button onclick="printAvance()" id="sub">Reporte de progreso</button>
          <button onclick="sendGmat()" id="sub">Uso de materiales</button>
          <button onclick="sendGtr()" id="sub">Avance de trabajadores</button>
          <button id="sub" onClick="ConsultaCosto('<?php echo $UIDactividad;?>')">Detalle de costo</button>
          <button id="sub" onClick="sendGeq()">Uso de equipamiento</button></td></tr>
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