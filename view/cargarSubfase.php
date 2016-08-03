<select name="subfase" id="subfase" required>
<?php
require_once("../db/connect.php");
if(isset($_GET["idfase"])){
	if($_GET["idfase"]!="nulo"){
$sql=$dbh->prepare("select *from subfase");
$sql->execute();
if($sql->rowCount()>0){
	foreach($sql->fetchAll() as $row){
		if($row["IDfase"]==$_GET["idfase"]){
		?>
        <option value="<?php echo $row["IDsubfase"];?>"><?php echo $row["nombre"];?>
        <?php
		}
		}
	}else{
		echo "Error al cargar la consulta";
		}
}else{
	?>
    <option value="">_sin subfase relacionada
    <?php
	}
}
?>
</select>