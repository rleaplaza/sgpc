<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edicion de submenús</title>
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../../css/css.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javsacript" src="../../js/tabber.js"></script>
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
				color:#093;
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
<img src="../../images/edit.png" width="50" height="50"/><br>
<input type="submit" value='Volver a listado de subMenús y opciones' onClick='history.back();' id="button">
<legend><h2>Información de submenú a editar</h2></legend>
<?php
if(isset($_SESSION["username"])){
if(isset($_GET["idopcion"])){
	try{ require_once("../../db/connect.php");
	     $sql=$dbh->prepare("select *from opcion where IDopcion=?");
		 $sql->bindParam(1,$_GET["idopcion"]);
		 $sql->execute();
		 if($sql->rowCount()>0){
	      foreach($sql->fetchAll() as $row){
		 ?>
        <form class="usuario" id="web form" method="post">
        <table>
        <div><tr><td><label>Codigo de opción</label></td>
                 <td><input type="text" value="<?php echo $row["IDopcion"]?>" disabled="disabled"></td></tr></div>
        <div><tr><td><label>Nombre de opción</label></td>
                 <td><input type="text" name="opcion" class="opcion" value="<?php echo $row["nombreOpcion"];?>" maxlength="40"><img src="../../images/editable.jpg" height="23" width="23" title="campo editable"></td></tr></div>
        <div><tr><td><label>Descripcion</label></td>
                 <td><textarea name="desc" id="desc" class="desc" rows="6" cols="30"><?php echo $row["descripcion"];?></textarea><img src="../../images/editable.jpg" height="23" width="23" title="campo editable"></td></tr></div>
         <div><tr><td><label>Fecha de creación</label></td>
                 <td><input type="text" value="<?php echo $row["fecCreacion"];?>" disabled="disabled"></td></tr></div>
         <div><tr><td><label>Hora de creación</label></td>
                 <td><input type="text" value="<?php echo $row["hraCreacion"];?>" disabled="disabled"></td></tr></div>
                 <input type="hidden" name="idopcion" class="idopcion" value="<?php echo $row["IDopcion"];?>">
          <div class="ultimo">
                <img src="../../images/ajax.gif" class="ajaxgif hide"/>
                <div class="msg"></div>
                <tr><td><button class="boton_envio" name="editar">Editar</button></td></tr>
                </div>
        </table>
        </form>
     <script type="text/javascript" src="../../js/edit/editOpcion.js"></script>
                 <?php
				 }
			 }
		
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
	}else{
		
		header("location: ../../index.php");
		}
	}else{
		header("location: ../../index.php");
		}
?>
</body>
</html>