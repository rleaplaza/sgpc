<?php session_start();
#Este archivo corresponde al programa principal que es donde se despliegan los menús de opciones del usuario en sesión
#De este programa se envían los enlaces a todas las páginas a donde se tengan permisos usando las opciones
?>
<html>
<head>
<link href="../images/favicon.ico" type="image/x-icon" rel="shortcut icon" />
 <meta http-equiv="content-type" content="text/html;charset=utf-8" />
 <title>Menú principal</title>
 <!--Llamada a los archivos javascript jquery, menu, ajax, funciones y  -->
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/menu.js"></script>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<link href="../css/menu.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
iframe#login{
	 background-color:#FFF;
	}
</style>
<link href="../css/estiloPrincipal.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="initPage()">
<div style="position:absolute; left:0px; top:1px; width:728px; height:70px "><img src="../images/logo.png" width="260" height="60"></div><iframe id="login" frameborder="0" align="center" scrolling="no" height="104" width="1349" src="<?php echo("../datoslogin.php");?>"></iframe>
<p align="center">&nbsp;</p>
    <?php 
if(isset($_SESSION["username"])){//verifica la existencia de la sesión
	try{ 
	require_once("../db/connect.php");//llamada al archivo de conexión
	$query=$dbh->prepare("select *from usuario where username=?");//consulta la información del usuario
	$query->bindParam(1,$_SESSION["username"]);//enlaza al ID de sesión
	$query->execute();//ejecuta la instrucción
	$row=$query->rowCount();//captura la cantidad de files
	if($row>0){
$data=$query->fetch();
$notificar=$data['notificar_sesion'];
//echo $notificar;

?>
<?php echo("<span><p align=left>"."<a href=javascript:cargarPagina('registros/editcuenta.php') class=enlace><label>Usuario: ".strtoupper($_SESSION["username"]))." (Editar cuenta)</label></a>";
		}
		
		
	?>
       <div id="menu">
       <ul class="menu"> 
       <?php
	   //consulta de los menús en base a los permisos asignados
      $sql=$dbh->prepare("SELECT DISTINCT menu.IDmenu,nombreMenu
                          FROM menu, submenu, opcion, permiso, usuario
                          WHERE menu.IDmenu = submenu.IDmenu
                          AND submenu.IDsubmenu = opcion.IDsubmenu
                          AND opcion.IDopcion = permiso.IDopcion
                          AND permiso.USR_UID = usuario.USR_UID
                          AND usuario.username =?
                          order by nombreMenu asc");
      $sql->bindParam(1,$_SESSION["username"]);
	  $sql->execute();
	   foreach($sql->fetchAll() as $row){
		 $idmenu=$row[0];  
	?>
       <li><a href="#" class="parent"><span><?php echo $row["nombreMenu"];?></span></a>
       <div><ul>
           <?php
		   //consulta de submenus en base a los permisos
      $sql1=$dbh->prepare("select distinct submenu.IDsubmenu,nombreSubmenu from submenu,opcion,permiso,usuario
	                       where submenu.IDsubmenu=opcion.IDsubmenu
	 					   and opcion.IDopcion=permiso.IDopcion
						   and permiso.USR_UID=usuario.USR_UID
					       and username=?
						   and submenu.IDmenu=?
						   order by submenu.nombreSubmenu asc");
      $sql1->bindParam(1,$_SESSION["username"]);
	  $sql1->bindParam(2,$idmenu);
      $sql1->execute();
		   foreach($sql1->fetchAll() as $sub){
			   $idsubmenu=$sub[0];
			   ?>
               <li><a href="#" class="parent"><span><?php echo $sub["nombreSubmenu"];?></span></a>
               <div><ul>
                  <?php
				  //consulta de opciones en base a los permisos
                  $sql2=$dbh->prepare("select distinct opcion.IDopcion,nombreOpcion,url from                                       opcion,permiso,usuario 
				                       where opcion.IDopcion=permiso.IDopcion
				                       and permiso.USR_UID=usuario.USR_UID
				                       and opcion.IDsubmenu=?
				                       and username=?
				                       order by opcion.IDopcion asc");
				  $sql2->bindParam(1,$idsubmenu);
				  $sql2->bindParam(2,$_SESSION["username"]);
				  $sql2->execute();
				  foreach($sql2->fetchAll() as $opt){
					  $idopcion=$opt[0];
					  ?>
 <li><a href="javascript:cargarPagina('<?php echo $opt["url"]."?idopcion=$opt[0]";?>')"><span><?php echo $opt[1];?></span></a></li>
                      <?php
					  }
				  ?>
               </ul></div>
               <?php
			   }
		   ?>
       </ul></div>
       </li> 
      <?php    
}
}
    catch(PDOException $e){
        echo "Error".$e->getMessage();
        }
?>
</ul>
<li><a href="javascript:cargarPagina('inicio')"><span>NUESTRA EMPRESA</span></a></li>
<li><a href="<?php echo 'logout?id='.session_id();?>"><span>SALIR DE LA APLICACIÓN</span></a></li>
</div>
</body>
</html><br>
<iframe id="work" width="1341" height="580" frameborder="0" align="center" scrolling="no"></iframe>
<?php
}
else{ header("location: ../index.php");
	}
?>
