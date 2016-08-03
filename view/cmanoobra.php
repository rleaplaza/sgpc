<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de cargos</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableCargo").dataTable({
				"sScrollY":"200px",
				"bPaginate":true,
				"oLanguage":{
					"sUrl":"../traducciones/datatables.spanish.txt"
					}
				});
        });
   </script>
   <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
   <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type"text/javascript">
//Activar permiso
		var fun = function (param,param1) {
			//var idPerm = $(this).attr("tipoPerm");
			var idCargoM = param;
			var nameCargo=param1;
			ajaxFace = new LightFace.Request({
				url: 'trabajadorManoObra.php',
				buttons: [
					{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
				],
				request: { 
					data: { 
						IDCargoM: idCargoM || 'Id de cargo no asignado',
						NameCargo:nameCargo || 'Nombre de cargo no asignado'
					},
					method: 'post'
				},
				title: 'Trabajadores de mano de obra por cargo'
			}).open();
		};
		window.addEvent('domready',function(){
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
<link href="../css/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery-ui-1.9.2.datepicker.custom.min.js.css" rel="stylesheet" type="text/css">
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
		echo("<p align=center><label>".$row["nombremenu"]."-</label><br>");
		echo("<label>". $row["nombresubmenu"]."</label><br>");
		echo("<label>".$row["nombreopcion"]."</label></p>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
	}
	else{
		header("location: ../index.php");
		}
		?>
   <div class="tabber" id="tab2">
<div class="tabbertab">
        <h2><legend>REGISTRO DE CARGOS DE MANO DE OBRA</legend></h2>
        <img src="../images/cargoManoobra.jpg" width="50" height="50" />
        <table id="tableCargo" width="814" align="left">
       <thead>
           <tr>
           <th><label>Nombre</label></th>
           <th><label>Descripción</label></th>
           <th width="100"><label>Unidad de Trabajo</label></th>
           <th width="100"><label>Trabajadores activos</label></th>
           <th><label>Precio unitario BS</label></th>
           <th><label>Fecha de creación</label></th>
           <th></th>
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
				 #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			color:#FFF;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#03F;
			border-radius:8px 8px 8px 8px;
				}
				#button:hover{
					background:#09F;
					}
			</style>
        <?php
		$sql=$dbh->prepare("select *from cargomanodeobra order by descripcion");
		$sql->execute();
		$dbh->query("SET NAMES UTF8");
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$idcargom=$row["IDcargoM"];
				?>
                <tr>
                <td><?php echo $row["nombre"];?></td>
                <td><?php echo $row["descripcion"];?></td>
                <td align="center"><?php echo $row["unidadTrabajo"];?></td>
                <td align="center"><?php echo $row["cantidad"];?></td>
                <td align="center"><?php echo $row["precioUnitario"];?></td>
                <td align="center"><?php echo $row["fecCreacion"]. " ". $row["hraCreacion"];?></td>
                <td align="center"><a href="<?php echo "edit/editCargomanoobra.php?idcargo=$idcargom";?>">Editar</a></td>
                <td><input type="button" onclick="fun('<?php echo $idcargom;?>','<?php echo $row["nombre"];?>'); return false;" class="submit classPermisos" value="Consultar trabajadores" id="button"></td>
                </tr>
                <?php
				}
		}
				?>
                </table>
                </div>
    <?php
	$query=$dbh->prepare("CALL sp_permisopagina(?,?)");
	$query->bindParam(1,$_SESSION["username"]);
	$query->bindParam(2,$_GET["idopcion"]);
	$query->execute();
	if($query->rowCount()>0){
		foreach($query->fetchAll() as $row){
			?>
       <div class="tabbertab">
       <h2><legend><?php echo($row[0]);?></legend></h2>
       <?php require_once($row[1]);?>
    </div>
    <?php
			}
	}
	?>
    </div>
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