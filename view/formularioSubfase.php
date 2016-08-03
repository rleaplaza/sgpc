<?php session_start();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de nuevos parámetros</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
    <link href="../css/css.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="registros/lightface/Assets/LightFace.css" rel="stylesheet" type="text/css">
 <style>
 label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	   }
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
			legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
	   </style>
          <script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools.js"></script>
       <script type="text/javascript" src="registros/lightface/Source/mootools-more-drag.js"></script>

<script type="text/javascript" src="registros/lightface/Source/LightFace.js"></script>
<script type="text/javascript" src="registros/lightface/Source/LightFace.Request.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#nombre').blur(function(){
		
		$('#Info').html('<img src="../images/ajax.gif" alt="" />').fadeOut(1000);

		var nombre = $(this).val();		
		var dataString = 'nombre='+nombre;
		
		$.ajax({
            type: "POST",
            url: "consultas/consultaSubfase.php",
            data: dataString,
            success: function(data) {
				$('#Info').fadeIn(1000).html(data);
				//alert(data);
            }
        });
    });              
}); 
</script>   
  <script type="text/javascript">
	window.addEvent('domready',function(){
			
			document.id('sub').addEvent('click',function(){
				
				ajaxFace = new LightFace.Request({
					url: 'registros/addSubFase.php',
					buttons: [
						{ title: 'Cerrar', event: function() { this.close(); },color:'blue' }
					],
					request: { 
						data: { 
						    IDfase:document.id('fase').value || 'fase no almacenada',
							Subfase:document.id('subfase').value || 'subase no almacenada',
							Desc:document.id('desc').value || 'descripción no existente',
							IDplan:document.id('idplan').value || 'ID de plan no almacenado'
						},
						method: 'post'
					},
					title: 'Registro de subfases'
				}).open();
				limpiar();
			});
			
		});    
		function limpiar(){//functión para limpiar el formulario
			document.getElementById("subfase").value="";
			document.getElementById("desc").value="";
			
			}
</script>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
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
		echo("<label>Menu: <b>".$row["nombremenu"]."</b></label> ");
		echo("<label>Submenu: <b>". $row["nombresubmenu"]."</b></label> ");
		echo("<label>Opcion: <b>".$row["nombreopcion"]."</b></label><br>");
		if(isset($row)){
		$nombMenu=$row["nombremenu"];
		$nombSubmenu=$row["nombresubmenu"];
		$nombOpcion=$row["nombreopcion"];
		//regAuditoria($nombMenu,$nombSubmenu,$nombOpcion);
		require_once("consultas/mensajeAyuda.php");
		$idopcion=$_GET["idopcion"];
		$mensaje=consultaMensaje($idopcion);
		?>
        <img src="../images/param.png" height="40" width="40"><br>
       <label>Para obtener ayuda, colocar el mouse sobre la imagen</label><img src="../images/ayuda.jpg" height="20" width="20" title="<?php echo $mensaje;?>">
        <?php
		}
		else{
			header("location: ../index.php");
			}
	}
	//consulta del proyecto
	$consulta=$dbh->prepare("select nombre from proyecto where IDproyecto=?");
	$consulta->bindParam(1,$_POST["proyecto"]);
	$consulta->execute();
	$res=$consulta->fetch();
	$proyecto=$res[0];
	$idproyecto=$_POST["proyecto"];
	//consulta de la planificacion
	$query=$dbh->prepare("select IDplanificacion from planificacion where IDproyecto=? and fecFin is NULL");
	$query->bindParam(1,$idproyecto);
	$query->execute();
	$reg=$query->fetch();
	$idplanificacion=$reg[0];
	?>
    <img src="../images/gant.jpg" height="40" width="40"><br>
    <input type="submit" value="VOLVER AL FORMULARIO" onClick="history.back();" id="button">
    <fieldset>
    <legend>FORMULARIO DE SUBFASES</legend><label><?php echo $proyecto;?></label>
    <form method="post" class="usuario" id="form" name="formParam">
    <table align="left">
    <div><tr><td><label>Fase</label></td><td>
    <select name="fase" id="fase" class="fase">
    <?php
    $sql=$dbh->prepare("SELECT IDfase, nombre, concat( fecRegistro, ' ', hraRegistro ) AS fecha
FROM fase
where IDproyecto=?
ORDER BY fecha ASC");
	$sql->bindParam(1,$idproyecto);
	$sql->execute();
	if($sql->rowCount()>0){
		foreach($sql->fetchAll() as $result){
			?>
       <option value="<?php echo $result["IDfase"];?>"><?php echo $result["nombre"];?>
            <?php
			}
		}
	?>
    </select>
    </td></tr></div>
    <input type="hidden" value="<?php echo $idplanificacion;?>" id="idplan">
    <div><tr><td><label>Subfase</label></td><td><input type="text"  class="subfase" name="subfase" id="subfase" maxlength="100" required></td><div id="Info"></div></tr></div>
    <div><tr><td><label>Descripción</label></td><td><textarea name="desc" class="desc" id="desc" rows="6" cols="30" required></textarea></td></tr></div>
   
  <tr><td><input type="button" class="boton_envio" id="sub" value="REGISTRAR"></td><td><input class="reset" type="reset" value="VACIAR FORMULARIO"></td></tr>
 </div> 
    </table>
    </form>
    </fieldset>
    <?php
	}else{
		header("location: ../index.php");
		}
?>
</body>
</html>