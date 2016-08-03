<?php session_start(); //función de inicio de sesión?>
<html>
<head><meta charset="utf-8"><title>Registro de usuarios</title>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>
<script type="text/javascript" src="../js/ayuda.js"></script>
<script type="text/javascript" language="JavaScript">
        $(document).ready( function() {
            $("#tableuser").dataTable({//enlaza al id de la tabla de usuarios
				"sScrollY":"250px",//habilita el scroll vertical
				"bPaginate":true,//habilita la paginación
				"paging":true,
				"oLanguage":{//archivo de traducción al castellano
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
			.enlace{
			 text-decoration:none;
			 color:#00F;
				}
		    .enlace:hover{
			 text-decoration:underline;
			 color:#09F;
				 }
			 activo{
				 color:#093;
				  }
		     inactivo{
				color:#F00; 
			 }
			 .imagen{
				 cursor:pointer;
				 }
			</style>
<link href="../css/imagen.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	try{
	require_once("../db/connect.php");//llama a la conexión a base de datos
	require_once("registros/regAuditoria.php");//llama al archivo log de auditoría
	require_once("consultas/mensajeAyuda.php");
	#consulta el programa donde se está navegando
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
		regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);//función log de auditoría
		$mensaje=consultaMensaje($_GET["idopcion"]);
		?>
        <label>Ayuda del sistema</label><img src="../images/ayuda.jpg" height="20" width="20" onClick="ayuda('<?php echo $mensaje;?>')" class="imagen">
        <?php
		}
		
	}
	else{
		header("location: ../index.php");//redirige al login
		}
	?>
<div class="tabber" id="tab2">
<div class="tabbertab">
  <h2><legend>GESTIÓN DE USUARIOS</legend></h2>
  <img src="../images/usuarios.jpg" width="30" height="30"/>
  <table id="tableuser" width="1324" align="left">
    <thead>
           	  <tr>
                  <th width="145"><label>Usuario</label></th>
                  <th width="145"><label>Email</label></th>
                  <th><label>Estado</label></th>
                  <th width="175"><label>Fecha de Creación</label></th>
                  <th width="175"><label>Rol de usuario</label></th>
                  <th width="145"></th>
                  <th width="45"></th>
                  <th width="45"></th>
                  <th></th>
                  <th></th>
              </tr>
    </thead>
<?php
    $user=$_SESSION["username"];
	$sql=$dbh->prepare("select *from usuario");
	$sql->execute();
	foreach($sql->fetchAll() as $row){
		$id=$row[0];
		   ?>
           <style type="text/css">
		      p{font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
				  }
		   </style>
    <tr>
     <td align="center"><?php echo $row[1];//campo nombre de usuario?></td>
     <td align="center"><?php echo $row[3];//campo email?></td>
     <td align="center"><?php if($row[6]=="activo"){
                        echo "<activo>".$row[6]."</activo>";
						}else if($row[6]=="inactivo"){
					    echo "<inactivo>".$row[6]."</inactivo>";
							}//campo estado
                     ?></td>
     <td align="center"><?php echo $row[7]. " " .$row[8];//campo fecha y hora de creación?></td>
     <td><?php echo $row[9];//campo rol de usuario?></td> 
     <td align="center"><a href="<?php echo("registros/menus?id=$row[0]");//opción para registrar permisos?>" class="enlace"><img src="../images/asignarPermiso.jpg" title="Asignar permiso"  width="40" height="40" class="img"/></a></td>   
     <td align="center" width="85"><a href="<?php echo("permisoUsuario?id=$row[0]");//opción para registrar permisos?>" class="enlace"><img src="../images/permiso_asignado.png" title="Permisos asignados"  width="40" height="40" class="img"/></a></td>
     <td align="center" width="85"><a href="<?php echo("registros/asignaRol?idusuario=$row[0]");//opción para asignar roles?>" class="enlace"><img src="../images/rol de usuario.gif" title="Asignar rol"  width="40" height="40" class="img"/></a></td>
     <td width="85" align="center"><a href="<?php echo("../reportes/administracion/userActions?idusuario=".$row[0]."&user=".$user);?>"><img src="../images/pdf_1.jpg" width="40" height="40" title="Imprimir acciones en PDF" class="img"/></a></td>
     <td witdh="80" align="center"><a href="<?php echo("../reportes/administracion/excel/userActionsXls?idusuario=$row[0]")?>"><img src="../images/excel2013.png" width="40" height="40" title="Imprimir acciones en EXCEL" class="img"/></a></td>       
    </tr>
	<?php
		}
		?>
</table>
</div>    
</div>
<?php
}catch(PDOException $e){
		echo "Error inesperado ".$e->getMessage();
		}
}
else{  
header("location: ../index.php");//redirige al login
	}
?>
</body>
</html>