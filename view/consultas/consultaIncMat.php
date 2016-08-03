<?php session_start();?>
<meta charset="utf-8">
<style>
label{ font:Verdana, Geneva, sans-serif;
	   color:#00C;
	  }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
	   }
	   th{
		 background:#CCC;
		   }
</style>
<?php
require_once("../../db/connect.php");
if(isset($_SESSION["username"])){
	if(isset($_POST["IDproyecto"])){
		$uidproyecto=$_POST["IDproyecto"];
		$uidplan=$_POST["IDplan"];
		#consulta PDO
		$sql=$dbh->prepare("select mat.descripcion, mat.unidad,pm.cantidad from material as mat, proyecto_material as pm,                            proyecto as p
				            where p.IDproyecto=pm.IDproyecto
							and pm.IDmaterial=mat.IDmaterial
							and pm.IDproyecto=?");
		$sql->bindParam(1,$uidproyecto);
		$sql->execute();
		if($sql->rowCount()>0){
			?>
            <table>
            <th><label>Material</label></th>
            <th><label>Unidad</label></th>
            <th><label>Cantidad</label></th>
            <?php
			foreach($sql->fetchAll() as $row){
				?>
                <tr><td><?php echo $row[0];?></td>
                <td><?php echo $row[1];?></td>
                <td><?php echo $row[2];?></td>
                </tr>
                <?php
				}
				?>
                </table>
                <?php
			}else{
				echo "No se encontraron resultados";
				}
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
?>