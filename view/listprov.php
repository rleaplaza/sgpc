<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registro de encargados</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>


<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableEncargado").dataTable({
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
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		}
	}
	else{
		header("location: ../index.php");
		}
		?>
 <div class="tabber" id="tab2">
      <div class="tabbertab">
      <h2><legend>INFORMACION DE USUARIO</legend></h2>       
        <table id="tableEncargado" width="814" align="left">
      <thead>
            	<tr>
           <th><label>Username</label></th>
           <th><label>Rol de usuario</label></th>
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
		$sql=$dbh->prepare("SELECT USR_UID, username, nombreRol
                            FROM usuario, rol
                            WHERE usuario.IDrol = rol.IDrol
                            AND rol.IDrol = 'SC_PROVEEDOR' 
							order by username");
		$sql->execute();
		if($sql->rowCount()>0){
			foreach($sql->fetchAll() as $row){
				$iduser=$row["USR_UID"];
				?>
                <tr><td><?php echo $row["username"];?></td>
                <td><?php echo $row["nombreRol"];?></td>
                <td><a href="<?php echo "nuevoProveedor.php?iduser=$iduser";?>">Completar registro</a></td></tr>
                <?php
				}
		}
				?>
                </table>
                </div>
                <?php
    $query=$dbh->prepare("SELECT pagina_opcion.nombre, pagina_opcion.url
                          FROM opcion, pagina_opcion, permiso_pagina, usuario
                          WHERE opcion.IDopcion = pagina_opcion.IDopcion
                          AND pagina_opcion.IDpagina = permiso_pagina.IDpagina
                          AND permiso_pagina.USR_UID = usuario.USR_UID
                          AND username=?
                          AND opcion.IDopcion=?
                          and permiso_pagina.estado='activo'
					      order by pagina_opcion.nombre ASC");
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