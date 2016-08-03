<?php 
session_start();
?>
<html>
<!--Este programa se encarga de realizar la consulta de planes de compras -->
<head><title>Plan de compra</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery.jeditable.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({
				"sScrollY":"250px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type"text/javascript">
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idplan = param;//captura el parámetro id de planificación
			ajaxFace = new LightFace.Request({
				url: 'registros/finPlan.php',//url destino
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { //requerimiento de datos
					data: { 
						//campos requeridos
					    IDplan:idplan || 'ID de plan no encontrado',
						IDproyecto:document.id('idproyecto').value || 'Id de parámetro no ingresado'
					},
					method: 'post'//método post
				},
				title: 'Fin de la planificación'//título
			}).open();//abre la ventana
		};
		window.addEvent('domready',function(){//inicia el evento
			//$('.classPermisos').click(fun);
		});
	</script>
<style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
		</style>
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
if(isset($_SESSION["username"])){
	try{
	require_once("../db/connect.php");//llama a la conexión de base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoria
	#consulta para el programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
	$consulta->execute();//ejecuta la instrucción
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];//almacena el id de opción
		$row=$consulta->fetch();//devuelve el resultado en un arreglo
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
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
?>
<!--Esta porción de código se encarga de desplegar el título de la planificación, mostrar la imagen -->
      <h2><legend>PLANIFICACIONES DEL PROYECTO</legend></h2>
        <img src="../images/planificacion.png" width="30" height="30" /><!-- El tag img llama a la imagen .png-->
       <table id="tableParam" width="1200" align="left"><!--El tag table se encarga de la creación de la tabla -->
      <thead>
            	<tr><!--Define las cabeceras de la tabla-->
                    <th><label>Descripción</label></th>
                    <th><label>Fecha de inicio</label></th>
                    <th><label>Fecha de conclusión</label></th>
                    <th></th>
                </tr>
       </thead>
       <!--El tag style se encarga de definir los estilos para los textos label, legend, butones para dar mejor apariencia-->
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
<?php
    $idproyecto=$_GET["idproyecto"];//enlaza al id del proyecto
    #consulta para recuperar el proyecto
	$sql=$dbh->prepare("select *from planificacion where IDproyecto=?");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	foreach($sql->fetchAll() as $row){//recorre las filas del registro
		$idplan=$row[0];
		$idproyecto=$row[1];//almacena el ID del proyecto
		   ?>
     <tr>
     <td><?php echo $row[2];//campo descripción?></td>
     <td><?php echo $row[3];//fecha de inicio?></td>
     <td><?php echo $row[4];//fecha de conclusión?></td>
     <td align="center">
     <input type="hidden" value="<?php echo($idproyecto)?>" id="idproyecto"><input type="button" onclick="fun('<?php echo $idplan;?>'); return false;" class="submit classPermisos" value="Finalizar planificación" id="button"></td></tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");
	}
?>
</body>
</html>