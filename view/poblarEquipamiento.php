<select name="maquinaria" id="maquinaria" class="maquinaria" required>
<?php
require_once("../db/connect.php"); 
$selectCargo=$dbh->prepare("select * from maquinaria order by descripcion asc");
$selectCargo->execute();
foreach($selectCargo->fetchAll() as $fila){
	if($fila[1]==$_GET["idproveedor"]){
echo "<option value=".$fila[0].">".$fila[2]."</option>";
	}
}
?>
</select>