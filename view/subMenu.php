<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de Submenus</title>

<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tablesubMenu").dataTable({
				"sScrollY":"200px",
				"bPaginate":true
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
<link href="../css/reveal.css" rel="stylesheet" type="text/css">
<link href="../css/jquery.idealforms.min.css" rel="stylesheet" type="text/css">
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">

<style>
       label{ font:Verdana, Geneva, sans-serif;
		     color:#00C;
	        }
	  legend{font:Verdana, Geneva, sans-serif;
			 background:#CCC;
	         color:#009;
	         size:auto;
			}
        #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
	     #button:hover{
			background:#ddd;
			}
			</style>
<link href="../css/enlaces.css" rel="stylesheet" type="text/css">
</head>

<body>
<img src="../images/main.jpg" height="50" width="50"><br>
<?php
if(isset($_SESSION["username"])){
		require_once("../db/connect.php");
		$idmenu=$_GET["idmenu"];
		$consulta=$dbh->prepare("select *from menu where IDmenu=?");
		$consulta->bindParam(1,$idmenu);
		$consulta->execute();
		$fila=$consulta->fetch();
		if($consulta->rowCount()>0){
			echo("<label>Submenus del menú:</label> ".$fila["nombreMenu"]."<br>");
			 echo("<input type=submit value='Volver a listado de módulos' onClick='history.back();' id=button>");
			}
			?>
            <fieldset id="content">
           <legend>Listado de Submenús del sistema</legend>
          <table width="900" id="tablesubMenu" align="left">
                        <thead>
                        <tr>
                        <th><label>Nombre de SubMenu</label></th>
                        <th><label>Fecha de creación</label></th>
                        <th><label>Hora de creación</label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        </tr>
                        </thead>
             
       <?php
		$sql=$dbh->prepare("SELECT nombreSubmenu, submenu.fecCreacion,submenu.hraCreacion, submenu.IDsubMenu
                            FROM menu, submenu
                            WHERE menu.IDmenu = submenu.IDmenu
                            AND menu.IDmenu =?");
		$sql->bindParam(1,$idmenu);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				?>
                <tr>
                <td><?php echo $row["nombreSubmenu"];?></td>
                <td><?php echo $row["fecCreacion"];?></td>
                <td><?php echo $row["hraCreacion"];?></td>
                <td><a href="<?php echo "edit/editSubmenu.php?idsubmenu=$row[IDsubMenu]";?>" class="enlace">Editar</a></td>
                <td><a href="<?php echo "opcionList.php?idsubmenu=$row[IDsubMenu]";?>" class="enlace">Ver opciones</a></td> 
                <td><a href="<?php echo "nuevaOpcion.php?idsubmenu=$row[IDsubMenu]&nombreSubmenu=$row[nombreSubmenu]";?>" class="enlace">Nueva Opción</a></td>
                </tr>
                <?php
				}
				?>
                </table>
                </fieldset>
                <?php
		}
			}else{
		header("location: ../index.php");
		}
?>
</body>
</html>