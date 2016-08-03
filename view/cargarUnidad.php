<?php session_start();?>
<?php
require_once("../db/connect.php");
$idmaterial=$_GET["idmaterial"];
$sql=$dbh->prepare("select IDmaterial, unidad from material");
$sql->execute();
if($sql->rowCount()>0){
	foreach($sql->fetchAll() as $row){
	if($idmaterial==$row["IDmaterial"]){
		?>
       <input type="text" id="unidad" name="unidad" class="unidad" value="<?php echo $row["unidad"]?>" readonly required>
        <?php
		}	
	}
		}else{
			echo "no se encontraron resultados";
			}
?>