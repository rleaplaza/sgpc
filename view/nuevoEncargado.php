<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de encargados de mano de obra</title>
 <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.datepicker.min.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css">
<link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
   <style>
             label{ font:Verdana, Geneva, sans-serif;
		      color:#00C;
	         }
	         legend{font:Verdana, Geneva, sans-serif;
	          color:#009;
	           size:auto;
				 }
				 #sub{
				font-wight:bold;
				cursor:pointer;
				padding:5px;
				color:#093;
				margin: 0 10px 20 px 0;
				border: 1px solid #ccc;
				background:#eee;
				border-radius:8px 8px 8px 8px;
			}
	#sub:hover{
				background:#ddd;
					}
			</style>
  
  <script type="text/javascript">
$(document).ready(function() {	
	$('#ci').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var ci = $(this).val();		
		var dataString = 'ci='+ci;
		
		$.ajax({
            type: "POST",
            url: "consultas/cedulaDisponible.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
});    
</script>
</head>

<body>
<input type="submit" value='Volver a listado de encargados' onClick='history.back();' id="sub">
<?php
if(isset($_SESSION["username"])){
	require_once("../db/connect.php");
	if(isset($_GET["iduser"])){
	$iduser=$_GET["iduser"];
	$sql=$dbh->prepare("SELECT usuario.USR_UID, encargadomanoobra.CI
                        FROM usuario, encargadomanoobra
                        WHERE usuario.USR_UID = ?");
	$sql->bindParam(1,$iduser);
	$sql->execute();
	if($sql->rowCount()>0){
		$row=$sql->fetch();
		$cedula=$row["CI"];
		$query=$dbh->prepare("select *from encargadomanoobra where CI=?");
		$query->bindParam(1,$cedula);
		$query->execute();
		if($query->rowCount()==0){
		try{
	?>
    <fieldset>
    <legend>Formulario de Registro de encargados de mano de obra</legend>
    <form method="post" class="usuario" id="form" name="webForm">
    <table align="left">
    <div><tr><td><label>User ID:</label></td><td><input type="text" id="userid" class="userid" name="userid" disabled="disabled" value="<?php echo $row["USR_UID"];?>"/></td></tr></div>
    <div><tr><td><label>Nombres de Encargado:</label></td><td><input type="text" id="nombre" class="nombre" name="nombre" placeholder="Ronald" maxlength="40" /></td></tr></div>
    <div><tr><td><label>Apellido parterno:</label></td><td> <input type="text" id="app" class="app" name="app" placeholder="Loza" maxlength="40" /></td></tr></div>
     <div><tr><td><label>Apellido marterno:</label></td><td><input type="text" id="apm" class="apm" name="apm" placeholder="Perez" maxlength="40" /> </td></tr></div>
      <div><tr><td><label>Cédula de identidad:</label></td><td><input type="text" id="ci" class="ci" name="ci" placeholder="2555993 Ex La Paz" maxlength="40"/> </td><div id="Info"></div></tr></div>
      <div><tr><td><label>Empresa proveedora:</label></td><td><input type="text" id="empresa" class="empresa" name="empresa" placeholder="Empresa de mano de obra" maxlength="40" /> </td></tr></div>
      <div><tr><td><label>Dirección de la empresa:</label></td><td><input type="text" id="dir" class="dir" name="dir" placeholder="av 6 de marzo El Alto" maxlength="40" /> </td></tr></div>
      <div><tr><td><label>Teléfonos:</label></td><td><input type="text" id="tel" class="tel" name="tel" placeholder="24233904 - 72033449" maxlength="20" /> </td></tr></div>
    <div class="ultimo">
  <img src="../images/ajax.gif" class="ajaxgif hide"/>
  <div class="msg"></div>
  <tr><td><button  class="boton_envio">REGISTRAR</button></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <script type="text/javascript" src="../js/nuevoEncargado.js"></script>
    <?php
		}catch(PDOException $e){
			echo "Error inesperado".$e->getMessage();
			}
		}else{
			echo"<label>Registro ya completado</label>";
			}
	}
		
	}else{
		header("location: ../index.php");
		}
	}else{
		header("location: ../index.php");
		}
?>

</body>
</html>