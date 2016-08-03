<select name="ci" id="ci" required>
<?php
require_once("../db/connect.php");
$idproyecto=$_GET["idproyecto"];
$sql=$dbh->prepare("SELECT pm.CI_trabajador, IDcargoM, pm.nombre, pm.ap_p, pm.ap_m
                    FROM personalmanoobra AS pm, proyecto AS p, participa AS pt
                    WHERE pm.CI_trabajador = pt.CI_trabajador
                    AND pt.IDproyecto = p.IDproyecto
					and p.IDproyecto=?
                    AND asignado_actividad = 'no'
                    ORDER BY pm.nombre");
$sql->bindParam(1,$idproyecto);
$sql->execute();
if($sql->rowCount()>0){
	foreach($sql->fetchAll() as $row){
		if($row[1]==$_GET["idcargo"]){
		?>
        <option value="<?php echo $row[0];?>"><?php echo $row[2]." ".$row[3]." ".$row[4];?>
        <?php
		}
			}
		}	else{
			?>
            <option value="">No se dispone de trabajadores
            <?php
		}
?>
</select>