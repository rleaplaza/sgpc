<?php session_start();//función de inicio de sesión
#Este programa se encarga de listar las cotizaciones mediante las solicitudes previas ?>
<html>
<head><title>Registro de parámetros</title>
<meta charset="utf-8">
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {//functión de la tabla
            $("#tableParam").dataTable({
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la pagianción
				"oLanguage":{//traducción al idioma castellano
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
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
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	try{
	require_once("../db/connect.php");//llama a la conexión de base de datos
	require_once("registros/regAuditoria.php");//llama al log de auditoría
	#consulta del programa donde se está navegando
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);//enlaza al id de opción
	$consulta->execute();
	if($consulta->rowCount()>0){
		$idopcion=$_GET["idopcion"];
		$row=$consulta->fetch();
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función para registrar el log de auditoría
		}
		else{
			header("location: ../index.php");
			}
	}
?>
      <h2><legend>Solicitudes de cotización</legend></h2>
        <img src="../images/cotizador.jpg" width="30" height="30" />
       <table id="tableParam" width="1200" align="left">
      <thead>
            	<tr>
                    <th><label>Fecha</label></th>
                    <th><label>Número de solicitud</label></th>
                    <th><label>Proveedor</label></th>
                    <th></th>
                  
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
			</style>
<?php
#consulta para recuperar el número de solicitud, proveedor
	$sql=$dbh->prepare("SELECT fecha, nro_solicitud, empProveedora, p.IDproveedor
                        FROM solicitud_cotizacion AS s, proveedor AS p
                        WHERE s.IDproveedor = p.IDproveedor");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		   ?>
     <tr>
     <td align="center"><?php echo $row[0];//campo fecha?></td>
     <td align="center"><?php echo $row[1];//campo nro de solicitud de cotización?></td>
     <td align="center"><?php echo $row[2];//campo proveedor?></td>
     <td><a href="<?php echo("formCotizacion2.php?nro=$row[1]&idproveedor=$row[3]&idopcion=$idopcion");//url para abrir el formulario de cotización?>">Registrar cotización</a></td>
  </tr>
		<?php
		}
		?>
</table>
        <?php
	}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();//genera una exepción en caso de que la conexión falle
		}
?>	
<?php
}
else
{ header("location: ../index.php");//redirige al login en caso de que no se cumpla con las condiciones de acceso como variable de sesión
	}
?>
</body>
</html>