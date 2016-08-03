<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de opciones</title>

<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableopcion").dataTable({
				"sScrollY":"250px",
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
</head>

<body>
<img src="../images/main.jpg" height="50" width="50"><br>
<?php
if(isset($_SESSION["username"])){
		require_once("../db/connect.php");
		require_once("registros/regAuditoria.php");
		$idsubmenu=$_GET["idsubmenu"];
		$consulta=$dbh->prepare("select *from submenu where IDsubMenu=?");
		$consulta->bindParam(1,$idsubmenu);
		$consulta->execute();
		$fila=$consulta->fetch();
		if($consulta->rowCount()>0){
			echo("<label>Opciones del submenú</label> ".$fila["nombreSubmenu"]."<br>");
			 echo("<input type=submit value='Volver a listado de submenús' onClick='history.back();' id=button>");
			}
			?>
            <fieldset id="content">
           <legend>Listado de opciones de acceso</legend>
          <table width="900" id="tableopcion" align="left">
                        <thead>
                        <tr>
                        <th><label>Nombre de opción</label></th>
                        <th><label>Descripción</label></th>
                        <th><label>Fecha de creación</label></th>
                        <th><label>Hora de creación</label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        <th><label></label></th>
                        <th></th>
                        </tr>
                        </thead>
             
       <?php
		$sql=$dbh->prepare("SELECT nombreOpcion, descripcion, opcion.fecCreacion,opcion.hraCreacion, opcion.IDopcion
                            FROM submenu, opcion
                            WHERE submenu.IDsubmenu = opcion.IDsubmenu
                            AND submenu.IDsubmenu=?");
		$sql->bindParam(1,$idsubmenu);
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				?>
                <tr>
                <td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>
                <td><?php echo $row[3];?></td>
                <td><a href="<?php echo "edit/editOpcion.php?idopcion=$row[4]";?>">Editar</a></td>
                <td><a href="<?php echo "nuevoMensaje.php?idopcion=$row[4]";?>">Añadir mensaje de ayuda</a></td>
                <td><a href="<?php echo "subpermisos.php?idopcion=$row[4]";?>">Ver subpermisos</a></td>
                <td><a href="<?php echo "nuevoSubpermiso.php?idopcion=$row[4]&nombreopcion=$row[0]";?>">Nuevo subpermiso</a></td>
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