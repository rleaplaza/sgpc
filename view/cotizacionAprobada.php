<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de cotización</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableCotizacion").dataTable({
				"sScrollY":"200px",
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
   <script type"text/javascript">
//Activar permiso
		var fun = function (param) {
			//var idPerm = $(this).attr("tipoPerm");
			var idmat = param;
			ajaxFace = new LightFace.Request({
				url: 'registros/updateEstado.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDmat: idmat || 'Id de opcion no ingresado'
					},
					method: 'post'
				},
				title: 'Asignacion de permisos'
			}).open();
		};
		window.addEvent('domready',function(){
			//$('.classPermisos').click(fun);
		});
	</script>
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			  #button{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
	#button:hover{
				background:#ddd;
					}
					text{
				 font:Verdana, Geneva, sans-serif;
		      color:#00C;
			  font-size:18px;
				 }
		label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;  #button{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
		</style>
        <link href="../css/jquery.dataTables.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/demo_table_jui.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if(isset($_SESSION["username"])){
try{
	require_once("../db/connect.php");
	require_once("registros/regAuditoria.php");
	$consulta=$dbh->prepare("select nombremenu, nombresubmenu, nombreopcion 
	                         from menu, submenu, opcion
							 where menu.IDmenu=submenu.IDmenu
							 and submenu.IDsubmenu=opcion.IDsubmenu
							 and opcion.IDopcion=?");
    $consulta->bindParam(1,$_GET["idopcion"]);
	$consulta->execute();

	if($consulta->rowCount()>0){
		$row=$consulta->fetch();
		echo("<p align=center><text>Menú: <b>".$row["nombremenu"]."</b></text> ");
		echo("<text>Submenú: <b>". $row["nombresubmenu"]."</b></text> ");
		echo("<text>Opción: <b>".$row["nombreopcion"]."</b></text></p>");
			
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
	}
	else{
		header("location: ../index.php");
		}
		?>
        <img src="../images/cotizador.jpg" width="40" height="40" />
        <h2><legend>LISTADO DE COTIZACIONES APROBADAS PARA PEDIDO</legend></h2>
        <form method="post" class="usuario">
        <a href="<?php echo "registros/pedido.php";?>">Consultar pedido</a>
        <table><tr align="center"><td align="left"><input type="submit" class="boton_envio" onclick="this.form.action='registros/addPedido.php'" value="REALIZAR PEDIDO"></tr></td></table>
        </form>
<table id="tableCotizacion" width="814" align="left">
      <thead>
            	<tr>
           <th width="100"><label>Fecha de registro</label></th>
           <th width="50"><label>Descripción</label></th>
           <th width="50"><label>Unidad de medida</label></th>
           <th width="40"><label>Precio BS</label></th>
           <th width="40"><label>Cantidad ofertada</label></th>
           <th width="50"><label>Aprobado por</label></th>
           <th width="50"><label>Empresa Proveedora</label></th>
                </tr>
       </thead>

        <?php
		$sql=$dbh->prepare("SELECT c.fecRegistro, c.hraRegistro, descripcion, unidad, precio_bs, cant_disponible,                             aprobado_por, empProveedora
                            FROM material AS m, cotizacion AS c, proveedor AS p
                            WHERE m.IDmaterial = c.IDmaterial
                            AND m.IDproveedor = p.IDproveedor
                            AND estado = 'Aprobado'
                            ORDER BY c.hraRegistro DESC");
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				?>
                <tr>
                <td align="center"><?php echo $row[0]." ".$row[1];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4];?></td>
                <td align="center"><?php echo $row[5];?></td>
                <td align="center"><?php echo $row[6];?></td>
                <td align="center"><?php echo $row[7];?></td></tr>
                <?php
				}
		}
				?>
                </table>
            
                
        <?php
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		
		}
}else{
	header("location: index.php");
	}
?>
</body>
</html>