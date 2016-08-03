<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edicion de roles</title>
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
<input type="submit" value='Volver' onClick='history.back();' id="button">

<?php
if(isset($_SESSION["username"])){
if(isset($_POST["idmaquinaria"])){
	try{ require_once("../../db/connect.php");
	     $sql=$dbh->prepare("select *from maquinaria where IDmaquinaria=?");
		 $sql->bindParam(1,$_POST["idmaquinaria"]);
		 $sql->execute();
		 if($sql->rowCount()>0){
	      foreach($sql->fetchAll() as $row){
		 ?>
         <fieldset>
         <legend><h2>Información de Equipamiento</h2></legend>
        <form class="usuario" id="web form" method="post">
        <table>
        <div><tr><td><label>Equipamiento</label></td>
                 <td><textarea name="maquinaria" id="maquinaria" cols="6" rows="3" class="material" readonly><?php echo $row["descripcion"];?></textarea></td></tr></div>
<div><tr><td><label>Precio unitario Bs</label></td><td><input type="text" value="<?php echo $row["precio_elemental"];?>" class="precio" name="precio"></td></tr></div>
         <input type="hidden" name="idmaquinaria" class="idmaquinaria" value="<?php echo $row["IDmaquinaria"];?>">
                <tr><td><button class="boton_envio" name="editar">Editar</button></td></tr>
                </div>
        </table>
        </form>
        </fieldset>
     <script type="text/javascript" src="../../js/edit/editMaquinaria.js"></script>
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