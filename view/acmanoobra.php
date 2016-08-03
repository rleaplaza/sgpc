<?php  session_start();//función de inicio de sesión?>
<html>
<head><title>Registro de avance por trabajador</title>
<meta charset="utf-8">
<!--Llamada a los archivos javascript que derán mejor apariencia a la página-->
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//función para el ID de la tabla html
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la pagianción
				"oLanguage":{//archivo de traducción al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
        <!-- El archivo ajaxgr se encarga de genera ventanas modales
      Los archivos mootools y lightfase se encargan de mostrar ventanas modales cuando se procecen los formularios-->
        <script type="text/javascript" src="../js/ajaxgr.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){//evento dom
			
			document.id('button2').addEvent('click',function(){//inicia el evento del botón
				
				ajaxFace = new LightFace.Request({//intancia a la clase lightface
					url: 'registros/updateAvance.php',//url destino
					buttons: [//botón para cerrar la ventana con sus propiedades
						{ title: 'Cerrar', event: function() { 
						this.close();
						recargar();
						 },color:'blue' }
					],
					request: { 
						data: { //datos utilizados para enviar a la url
						    IDactividad:document.id('idactividad').value || 'nombre no agregado',
						},
						method: 'post'//método post
					},
					title: 'Informe de avances'//título de la ventana
				}).open();//abre la ventana
				
			});
			
		});  
			function recargar(){
			var int=self.setInterval("refresh()",5000);
			location.reload(true);
			}  
</script>
<!--Estilo para la página como la fuente, y el texto -->
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
        <!--Llamada a las hojas de estilo para dar mejor apariencia a las pantallas -->
<link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){ #valida que si la sesión exista el usuario pueda ver el registro, caso contrario envía a la página login
	try{
		#llama a los archivos externos para el programa
	require_once("../db/connect.php");//archivo de conexión de la BD
	require_once("registros/regAuditoria.php");//archivo log de auditoría
	#consulta PDO para el programa donde se está nabegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza el ID de opción
	$consulta->execute();//ejecuta la consulta
	if($consulta->rowCount()>0){//si la opción existe envia los parámetros al log de auditoría
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br> ");
		      echo("<label>". $row["nombresubmenu"]."</label><br>");
		      echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
		else{
			header("location: ../index.php");
			}
	}
	if(isset($_GET["idproyecto"])){
		if(isset($_GET["idactividad"])){
	$idproyecto=$_GET["idproyecto"];#captura el ID del proyecto
	$idactividad=$_GET["idactividad"];#captura del identificador de la actividad
	$idopcion=$_GET["idopcion"];
?>      <!--la etiqueta h2 aumenta el tamaño del texto y la etiqueta legend corresponde al estilo del texto -->
        <img src="../images/tareas.jpg" width="30" height="30" />
       <!--Texto con la etiqueta label correspondiente al estilo del texto, el tag image mostrará la imagen de ayuda, sus propiedades como dimensiones y el título que corresponde al mensaje de ayuda -->
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="25" width="25" title="Para realizar consultas de avances, presionar el botón Informar avance para cargar el formulario y llenar el avance, para consultar informe por trabajador, presionar el botón consultar informe para desplegar el listado de avances, para imprimir en PDF, presionar la imagen respectiva, para reflejar el total avanzado en la página anterior, presionar el botón Actualizar avance">
        <!--El formulario almacena el id del proyecto y de la actividad en campos hidden(ocultos), el botón finalizar redirige a la página de listado de avances, el botón de acutalización de avances guardará los últimos avances -->
        <form method="get">
        <input type="hidden" value="<?php echo $idproyecto;?>" name="proyecto">
        <input type="hidden" value="<?php echo $idopcion;?>" name="idopcion">
        <input type="submit" id="button" value="Salir" onClick="this.form.action='listActAvance.php'">
        <input type="hidden" value="<?php echo $idactividad;?>" id="idactividad">
        <input type="button" id="button2" value="Actualizar avance">
        </form>
        <!--La etiqueta table mostrará el listado de avances por mano de obra -->
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha de avance</label></th>
                    <th><label>Nombre de trabajador</label></th>
                    <th><label>Cargo</label></th>
                    <th><label>Avance acumulado</label></th>
                    <th></th>
                    <th></th>
                </tr>
       </thead>
       <!--Los estilos label y legend definen fuente y color de texto para mejorar la interfaz gráfica -->
       <!--Para los botones se establecen los estilos como color de texto, fondo y margnes -->
           <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
		    #button{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#00C;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#666;
					}
			 #button2{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#09F;
			border-radius:8px 8px 8px 8px;
			}
				#button2:hover{
					background:#666;
					}
			</style>
<?php
$user=$_SESSION["username"];
#consulta PDO para mostrar el registro de trabajadores asignados  a la actividad
	$sql=$dbh->prepare("SELECT pm.nombre, ap_p, ap_m, c.nombre, unidad_trabajo,total_trabajo,unidad_avance, total_unidad_avance, precio_productivo,                        at.subtotal_manoObra, fecha_avance,pm.CI_trabajador
                        FROM actividad_trabajador AS at, personalmanoobra AS pm, actividad AS a, cargomanodeobra AS c
                        WHERE c.IDcargoM = pm.IDcargoM
                        AND a.IDactividad = at.IDactividad
                        AND at.CI_trabajador = pm.CI_trabajador
						and a.IDactividad=?");
	$sql->bindParam(1,$idactividad);#enlace al id de actividad para ejecutar la consulta
	$sql->execute(); #ejecuta la consulta
	#arreglo para desplegar el registro en cuestión
	$avance_informado=0;
	foreach($sql->fetchAll() as $row){
		$ci=$row[11];
		$nombre=$row[0]." ".$row[1]." ".$row[2];//concatena el nombre del trabajdor
		   $cargo=$row[3];//captura del cargo
		   $avance_informado=$row[7];
		   ?>
     <tr>
     <td align="center"><?php echo $row[10];?></td>
     <td><?php echo $row[0]." ".$row[1]." ".$row[2];?></td>
     <td align="center"><?php echo $row[3];?></td>
     <td align="center"><?php echo $avance_informado." ".$row[6];?></td>
     <td align="center"><button id="button" onclick="editAvance('<?php echo $idactividad;?>','<?php echo $row[11];?>','<?php echo $nombre;?>')">Informar avance</button></td>
     <td><a href="<?php echo "../reportes/proyectos/repAvanceTrab.php?idactividad=$idactividad&ci=$row[11]&nombre=$nombre&cargo=$row[3]&avance=$avance_informado&user=$user";//el mensaje corresponde al enlace para imprimir el informe de avances?>" target="_blank"><img src="../images/pdf.jpg" height="30" width="30" title="Imprimir informe en PDF"></a></td>
     </tr>
		<?php
		}
		?>
</table>
        <?php
		}else{
			header("location: ../index.php");
			}
	}else{
		header("location: ../index.php");
		}
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//en caso de que la conexión falle se genera una excepción
		}
?>	
<?php
}
else
{ header("location: ../index.php");//dirige al usuario al login en caso de no tener el acceso permitido
	}
?>
</body>
</html>