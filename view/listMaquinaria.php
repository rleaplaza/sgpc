<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de maquinaria</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/ajaxgr.js"></script>
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
		echo("<p align=center><label>".$row["nombremenu"]."</label><br>");
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
 
        <h2><legend>LISTADO DE MAQUINARIA</legend></h2>
        <img src="../images/maquinaria1.jpg" width="50" height="50" />
        <table id="tableMaq" width="814" align="left">
      <thead>
            	<tr>
           <th><label>Descripción</label></th>
           <th witdh="40"><label>Unidad de medida</label></th>
           <th><label>Marca</label></th>
           <th><label>Modelo</label></th>
           <th><label>Nro de placa</label></th>
           <th><label>Potencia</label></th>
           <th><label>Precio BS</label></th>
           <th width="20"><label>Cantidad</label></th>
           <th width="20"><label>Proveedor</label></th>
           <th><label>Fecha de registro</label></th>
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
			</style>
        <?php
		$sql=$dbh->prepare("SELECT IDmaquinaria, descripcion, unidad, marca, modelo, nroplaca, potencia, precio_elemental,                             cantidad_disponible, empProveedora,maquinaria.fecRegistro, maquinaria.hraRegistro
                            FROM proveedor, maquinaria
                            WHERE proveedor.IDproveedor = maquinaria.IDproveedor
                          ");
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$idmaq=$row[0];
				?>
                <tr>
                <td><?php echo $row[1];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4];?></td>
                <td><?php echo $row[5];?></td>
                <td align="center"><?php echo $row[6];?></td>
                <td align="center"><?php echo $row[7];?></td>
                <td align="center"><?php echo $row[8];?></td>
                 <td align="center"><?php echo $row[9];?></td>
                <td><?php echo $row[10]. " ". $row[11];?></td>
                 <td align="center"><form action="edit/editMaquinaria.php" method="post">
                                   <input type="hidden" value="<?php echo $idmaq;?>" name="idmaquinaria">
                                   <input type="submit" value="EDITAR" id="button">          
                </form></td></tr>
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