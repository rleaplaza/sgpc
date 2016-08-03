<?php session_start();//función de inicio de sesión
#Este programa se encarga de mostrar la información general del proyecto
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<!-- Llamada a los archivos javascript para desplegar ventanas modales-->
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<!--El archivo ajaxgr se encarga de generar funciones para abrir ventanas modales -->

<script type="text/javascript" src="../js/ajaxgr.js"></script>
<script type="text/javascript">
	//window.addEvent('domready',function(){//intancia el evento dom
		//	document.id('sub1').addEvent('click',function(){//llama al evento click
			//	ajaxFace = new LightFace.Request({//instancia a la clase lightfase
				//	url: 'registros/addValorAcumulado.php',//url destino
					//buttons: [//establece la creación del botón
						//{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					      //   ],// botón de cerrado
				//	request: { //arreglo que contiene otro arreglo para enviar los datos del formulario
				  //  data: { 
					//	    IDproyecto:document.id('idproyecto').value || 'id de proyecto no agregado',
						//	CostoProg:document.id('costoprog').value || 'costo programado',
						//	Progreso:document.id('progreso').value || 'progreso no agregado'
						 // },
						//method: 'post'
					 //},
					//title: 'Registro de valor acumulado'//título de la ventana
				//}).open();//abre la ventana
		//	});
	//	});    
</script>
<script type="text/javascript">
	window.addEvent('domready',function(){//intancia el evento dom
			
			document.id('sub2').addEvent('click',function(){//llama al evento click
				
				ajaxFace = new LightFace.Request({//instancia a la clase lightfase
					url: 'registros/finProyecto.php',//url destino
					buttons: [//establece la creación del botón
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDproyecto:document.id('idproyecto').value || 'id de proyecto no agregado',
						},
						method: 'post'
					},
					title: 'Registro de valor acumulado'
				}).open();
				
			});
			
		});    
</script>
<!--Los estilos label, sub definen las apariencias de los texto que lleven estas propiedades y los botones, se les define, fuente, color, margenes, borde, color de fondo, hover, que se inicia al colocar el puntero sobre el control -->
 <style>
 label{ font:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
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
			#sub1{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00F;
			border-radius:8px 8px 8px 8px;
			}
			#sub1:hover{
				background:#06F;
			    color:#FFF;
					}
			#sub2{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00F;
			border-radius:8px 8px 8px 8px;
			}
		    #sub2:hover{
			  background:#06F;
			  color:#FFF;
					}
			table{
				border-radius:10px;
				box-shadow:0px 0px 13px  rgba(0,0,0,0.5);
				-web-kit-box-shadow:0px 0px 13px rbga(0,0,0,0.5);
					}
			table td{
				border-radius:5px;
				border:1px;
			    background:rgba(156,184,121,0.2);
				}
			table th{
				border-radius:5px;
				border:1px;
				background:rgba(189,184,121,0.2);
				}
		   .image{
				float:left;
				}
	   </style>
</head>
<body>
<?php
#Este programa realiza el despliegue de la información de un determinado proyecto así como la impresión de reportes gráficos de duraciones y costos
if(isset($_SESSION["username"])){#valida la sesión
	require_once("../db/connect.php");//archivo de conexión global a la BD
	require_once("registros/regAuditoria.php");//programa que registra el log de auditoría
	$user=$_SESSION["username"];
	#consulta de la opción para recuperar el nombre del programa del menú
		$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_POST["idopcion"]);//enlaza al id de opción
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
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_POST["idopcion"];
		//$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/graph.png" height="30" width="30"><img src="../images/proyectos.jpg" height="30" width="30"><br>
        <input type="submit" value="VOLVER AL FORMULARIO" onclick="history.back();" id="sub"><input type="button" id="sub2" value="Finalizar proyecto"><br>
       <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" title="Para realizar la impresión de reportes de seguimiento presionar los botones reporte de duracion, reporte de costos, respectivamente
Los botones que imprimen gráficos según la elección barra/torta son: Informe por duración, Informe por costo,Informe de progreso e Informe por cargos, las demás opciones como Informe de costo previsto, porcentaje programado se muestran sólamente en barra">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	?>
    <?php
	#captura de variables, ejecución de la consulta según el ID del proyecto
	if(isset($_POST["proyecto"])){
	$UIDproyecto=$_POST["proyecto"];//captura el id del proyecto
	$sql=$dbh->prepare("select *from proyecto where IDproyecto=?");
	$sql->bindParam(1,$UIDproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		$idproyecto=$row["IDproyecto"];
		#asigna las variables de duración y costo dentro del resultado
		$duracion_prog=$row["duracion_programada"];
		$duracion_real=$row["duracion_real"];
		$costoProg=$row["totalProyecto"];
		$costoReal=$row["costo_real"];
		$progreso=$row["porcentaje_progreso"];
		$estado=$row["estado"];
		$diferencia_costo=$costoProg-$costoReal;
	?>
    <fieldset>
    <legend>INFORMACIÓN DEL PROYECTO</legend>
    <table align="left" border="2" id="tableProyecto" width="1300">
    <th><a href="<?php echo "../reportes/proyectos/infoProyecto.php?idproyecto=".$UIDproyecto."&user=".$user;?>"><img src="../images/pdf_1.jpg" class="image" height="20" width="20" title="Imprimir en PDF"></a>
    <label>Referencia</label></th>
    <th></th>
    <input type="hidden" value="<?php echo $row["nombre"];?>" id="proyecto">
    <input type="hidden" value="<?php echo $UIDproyecto;?>" id="idproyecto">
    <input type="hidden" value="<?php echo $duracion_prog;?>" id="duracionpr">
    <input type="hidden" value="<?php echo $duracion_real;?>" id="duracionreal">
    <input type="hidden" value="<?php echo $costoProg;?>" id="costoprog">
    <input type="hidden" value="<?php echo $costoReal;?>" id="costoReal">
    <input type="hidden" value="<?php echo $progreso;?>" id="progreso">
      <tr><td><label>Nombre</label></td><td><?php echo $row["nombre"];?></td></tr>
      <tr><td><label>Fecha de inicio</label></td><td width="500"><?php echo $row["fecInicio"];?></td></tr>
      <tr><td><label>Fecha de finalización</label></td><td width="500"><?php echo $row["fecFinal"];?></td></tr>
      <tr><td><label>Días programados</label></td><td><?php echo $row["duracion_programada"]." dias";?></td></tr>
      <tr><td><label>Días utilizados</label></td><td><?php echo $row["duracion_real"]. " dias";?></td></tr>
      <tr><td><label>Costo programado</label></td><td><?php echo $row["totalProyecto"]. " Bs";?></td></tr>
      <tr><td><label>Costo real</label></td><td><?php echo $row["costo_real"]. " Bs";?></td></tr>
      <tr><td><label>Diferencia de costos</label></td><td><?php echo $diferencia_costo." Bs";?></td></tr>
      <tr><td><label>Porcentaje de progreso</label></td><td><?php echo $row["porcentaje_progreso"]." %";?></td></tr>
      <tr><td><label>Estado</label></td><td><?php echo $estado;?></td></tr>
   <tr><td><label>Materiales programados</label></td><td>
   <select name="idmaterial" id="idmaterial"><?php 
	  $consulta=$dbh->prepare("SELECT m.IDmaterial,m.descripcion, m.unidad, sum(cantidad_utilizada) as cantidad
                               FROM material m, actividad_material am, actividad a, subfase sf, fase f, proyecto p
                               WHERE m.IDmaterial = am.IDmaterial
                               AND am.IDactividad = a.IDactividad
                               AND a.IDsubfase = sf.IDsubfase
                               AND sf.IDfase = f.IDfase
                               AND f.IDproyecto = p.IDproyecto
							   and p.IDproyecto=?
							   group by m.descripcion");
	  $consulta->bindParam(1,$idproyecto);
	  $consulta->execute();
	  $filas=$consulta->rowCount();
	  if($filas>0){
		  foreach($consulta->fetchAll() as $fila){
			  ?>
              <option value="<?php echo $fila[0];?>"><?php echo $fila[1];?>
              <?php
			  }
		  }else{
			  ?>
              <option value="">Ningún material programado
              <?php	  
				}
	  ?></select></td></tr>
      <tr><td><label>Equipamiento programado</label></td><td>
   <select name="idequipamiento" id="idequipamiento"><?php 
	  $consulta=$dbh->prepare("select m.IDmaquinaria,m.descripcion, m.unidad, sum(cant_asignada) as cantidad_asignada, sum(cantidad_usada) as cantidad_usada
                              from maquinaria m, actividad_maquinaria am, actividad a, subfase sf, fase f, proyecto p
                               where m.IDmaquinaria=am.IDmaquinaria
                               and am.IDactividad=a.IDactividad
                               and a.IDsubfase=sf.IDsubfase
                               and sf.IDfase=f.IDfase
                               and f.IDproyecto=p.IDproyecto
							   and p.IDproyecto=?
							   group by descripcion");
	  $consulta->bindParam(1,$idproyecto);
	  $consulta->execute();
	  $filas=$consulta->rowCount();
	  if($filas>0){
		  foreach($consulta->fetchAll() as $fila){
			  ?>
              <option value="<?php echo $fila[0];?>"><?php echo $fila[1];?>
              <?php
			  }
		  }else{
			  ?>
              <option value="">Ningún equipamiento programado
              <?php	  
				}
	  ?></select></td></tr>
      <tr><td><label>Fases para costo previsto</label></td>
          <td><select name="fase" id="fase">
          <?php 
		   $query=$dbh->prepare("select IDfase, nombre, concat(fecRegistro,' ',hraRegistro) as fecha from fase where IDproyecto=? order by fecha asc");
		   $query->bindParam(1,$idproyecto);
		   $query->execute();
		   if($query->rowCount()>0){
			   foreach($query->fetchAll() as $dato){
				   echo "<option value=".$dato[0].">".$dato[1];
				   }
			   }else{
				   echo "<option value=''>Ninguna fase programada";
				   }
		  ?>
          </select>
          </td>
          </tr>
       <tr><td><label>Tipo de gráfico a imprimir</label></td>
  <td><select name="tipo" id="tipo">
  <option value="">_Seleccione un tipo de gráfico
  <option value="barra">Barra
  <option value="torta">Torta
  </select>
  </td></tr>
  <tr><td><fieldset><legend>Informes</legend>
          <button onclick="sendGrduracion()" id="sub">Duración</button>
          <button onclick="sendGrcosto()" id="sub">Costos</button>
          <button onclick="sendGrProgreso()" id="sub">Progreso</button>
          <button onclick="sendGCostoPrevisto()" id="sub">Costo Previsto por fases</button>
          <button onclick="sendMaterial()" id="sub">Consumo de materiales</button>
          <button onclick="sendMaquinaria()" id="sub">Uso de equipamiento</button>
          <form method="post">
          <input type="hidden" value="<?php echo $UIDproyecto;?>" id="sub" name="idproyecto">
          <input type="hidden" value="<?php echo $row["nombre"];?>" name="proyecto">
          <input type="submit" id="sub1" value="Recursos programados" onClick="this.form.action='recursos.php'">
          </form></fieldset></td></tr> 
    </table>
    </fieldset>
    <?php
	}else{
		echo "Sin resultados para mostrar";
		}
	}else{
		echo "Ningún proyecto existente";
		}
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>