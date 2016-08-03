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
            $("#tableMaq").dataTable({
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
	#button1:hover{
				background:#ddd;
					}
					 #button1{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#F00;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
			#button:hover{
				background:#ddd;
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

		?>
        <img src="../images/materiales.jpg" width="50" height="50" /> 
        <h2><legend>LISTADO DE MATERIALES</legend></h2>
        <input type="submit" value="Volfer al formulario principal" onClick="history.back();" id="button"><br> 
        <table id="tableMaq" width="814" align="left">
      <thead>
            	<tr>
           <th width="50"><label>Número de solicitud</label></th>
           <th width="90"><label>Descripción</label></th>
           <th width="80"><label>Unidad</label></th>
           <th width="50"><label>Precio</label></th>
           <th width="50"><label>Cantidad solicitada</label></th>
           <th width="100"></th>
                </tr>
       </thead>

        <?php
		$sql=$dbh->prepare("SELECT dsc.nro_solicitud, m.IDmaterial, descripcion, m.unidad, precio_bs, cantidad_sol
FROM material AS m, det_solicitud_cotizacion AS dsc, solicitud_cotizacion AS sc
WHERE m.IDmaterial = dsc.IDmaterial
AND dsc.nro_solicitud = sc.nro_solicitud
                           ");
		$sql->bindParam(1,$proveedor);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$idmat=$row[1];
				$unidad=$row[2];
				?>
                <tr>
                <td align="center"><?php echo $row[0];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4];?></td>
                <td align="center"><?php echo $row[5];?></td>
                <td align="center"><a href="<?php echo "formSolicitudCotizacion.php?nro=$row[0]&idmat=$idmat"?>">Editar cantidad</a></td></tr>
               
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