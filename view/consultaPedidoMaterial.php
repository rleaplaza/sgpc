<?php 
session_start();//función de inicio de sesión
?>
<html>
<head><title>Registro de materiales solicitados para la actividad</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableParam").dataTable({//enlaza el id de la table
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la paginación
				"oLanguage":{//archivo de traducción al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
        </script>
    <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

  <script type="text/javascript">
	window.addEvent('domready',function(){//inicia el evento de la ventana
			
			document.id('button').addEvent('click',function(){//captura el id del botón para iniciar el evento
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addEntrega.php',//url destino
					buttons: [//botón de cerrado
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //captura de los datos requeridos para procesar la entrega de materiales
						    IDpedido:document.id('idpedido').value || 'Número de pedido no almacenado',
						    NroEntrega:document.id('nroentrega').value || 'Numero de entrega no almacenado',
							IDplan:document.id('idplan').value || 'cargo no ingresado',
							IDproyecto:document.id('idproyecto').value || 'ID de proyecto no almacenado',
							IDactividad:document.id('idactividad').value || 'ID de actividad no almacenado'
						},
						method: 'post'
					},
					title: 'Entrega de materiales'
				}).open();
				
			});
			
		});    
</script>

  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('button2').addEvent('click',function(){//captura el segundo botón
				
				ajaxFace = new LightFace.Request({
					url: 'consultas/consultaDetMaterial.php',//url destino para consulta detalle de materiales
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { //datos requeridos
						    IDpedido:document.id('idpedido').value || 'nombre no agregado',
							IDactividad:document.id('idactividad').value || 'cargo no ingresado'
						},
						method: 'post'
					},
					title: 'Registro de detalle de pedido'
				}).open();
				
			});
			
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
if(isset($_SESSION["username"])){//valida la existencia de la sesión
	try{
	require_once("../db/connect.php");//captura de la conexión a base de datos
	require_once("registros/generaEntrega.php");
	#campos que serán usados para almacenarlos en la tabla de entrega
	$idpedido=$_GET["idpedido"];
	$idempleado=$_GET["idempleado"];
	$idactividad=$_GET["idactividad"];
	$idproyecto=$_GET["idproyecto"];
	$idplan=$_GET["idplan"];
	$estado=$_GET["estado"];
	if($estado=="Pendiente"){
	#genera el registro de entrega
$nroEntrega=generaEntrega($idpedido,$idempleado,$idactividad);//función que envía los parámetros mínimos
	#consulta PDO para mostrar el programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//captura del ID de la opción
	$consulta->execute();//ejecuta la instrucción
	if($consulta->rowCount()>0){//en caso de que la cantidad de filas sean mayor a cero, desplegará el nombre del programa
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<label>".$row["nombremenu"]."-</label> ");
		echo("<label>". $row["nombresubmenu"]."-</label> ");
		echo("<label>".$row["nombreopcion"]."</label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		}
		else{
			header("location: ../index.php");//dirige a la página principal en caso de no existir la variable opción
			}
	}
?>   <input type="hidden" value="<?php echo $idpedido;?>" id="idpedido"> 
     <input type="hidden" value="<?php echo $nroEntrega;?>" id="nroentrega">
     <input type="hidden" value="<?php echo $idplan;?>" id="idplan">
     <input type="hidden" value="<?php echo $idproyecto;?>" id="idproyecto">
     <input type="hidden" value="<?php echo $idactividad;?>" id="idactividad">
     <input type="button" value="Procesar pedido" id="button">
     <input type="button" value="Consultar detalle" id="button2">
      <h2><legend>MATERIALES SOLICITADOS PARA LA ACTIVIDAD</legend></h2>
        <img src="../images/almacen.jpg" width="30" height="30" />
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Nro de pedido</label></th>
                    <th><label>Descripción</label></th>
                </tr>
       </thead>
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
			color:#00C;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button:hover{
					background:#ddd;
					}
					#button2{font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#03F;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
				#button2:hover{
					background:#ddd;
					}
			</style>
<?php


#consulta el detalle de pedido en almacén
	$sql=$dbh->prepare("SELECT Nro_pedido, descripcion from pedido_almacen where Nro_pedido=?");
	$sql->bindParam(1,$idpedido);//enlaza al nro del pedido
	$sql->execute();
	#el arreglo se encarga de desplegar el resultado de la consulta
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td><?php echo $row[0];?></td>
     <td><?php echo $row[1];?></td>
 </tr>
		<?php
		}
		?>
</table>
        <?php
	}else{
		echo "<label>Pedido ya atendido</label>";
		}
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una excepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");//devuelve al login en caso de no contar con el permiso
	}
?>
</body>
</html>