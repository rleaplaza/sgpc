<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de maquinaria</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableMaq").dataTable({
				"sScrollY":"200px",
				"bPaginate":true
				});
        });
   </script>
   <style type="text/css">
			body { font-family: "HelveticaNeue","Helvetica-Neue", "Helvetica", "Arial", sans-serif; }
			.big-link { display:block; margin-top: 100px; text-align: center; font-size: 70px; color: #06f; }
			 #button{ font-wight:bold;
			   cursor:pointer;
			   padd ing:5px;
		       margin: 0 10px 20 px 0;
			   border: 1px solid #ccc;
			   background:#eee;
			   border-razdius:8px 8px 8px 8px;
		      }
		 #button:hover{
				background:#ddd;
			}
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
	if(isset($_GET["idmaq"])){
	   $idmaquinaria=$_GET["idmaq"];
	   $sql=$dbh->prepare("select descripcion from maquinaria where IDmaquinaria=?");
	   $sql->bindParam(1,$idmaquinaria);
	   $sql->execute();
	   $res=$sql->fetch();
	
		?>
 <label>Ayuda del sistema</label>
 <img src="../images/ayuda.jpg" height="30" width="30" title="Llenar el formulario con la correspodiente información de la subfase y la descripción"/><br>
 <input type="submit" value='Volver a listado de maquinaria' onClick='history.back();' id="button"><br>
        <h2><legend>LISTADO DE ITEMS</legend><label>REF.</label><?php echo $res["descripcion"]?></h2>
        <img src="../images/maquinaria1.jpg" width="50" height="50" />
        <table id="tableMaq" width="814" align="left">
      <thead>
            	<tr>
           <th width="6"><label>Nro</label></th>
           <th width="100"><label>Descripción</label></th>
           <th width="100"><label>Estado</label></th>
           <th width="100"><label>Fecha de registro</label></th>
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
		$sql=$dbh->prepare("SELECT *from item_maquinaria where IDmaquinaria=?");
		$sql->bindParam(1,$idmaquinaria);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				?>
                <tr>
                <td><?php echo $row[0];?></td>
                <td align="center"><?php echo $row[2];?></td>
                <td align="center"><?php echo $row[3];?></td>
                <td align="center"><?php echo $row[4]." ".$row[5];?></td></tr>
                <?php
				}
		}
				?>
                </table>
            
                
        <?php
		}
	else{
		header("location: ../index.php");
		}
	}catch(PDOException $e){
		echo "Error inesperado".$e->getMessage();
		
		}
}else{
	header("location: index.php");
	}
?>
</body>
</html>