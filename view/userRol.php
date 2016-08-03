<?php session_start();?>
<html>
<head><meta charset="utf-8"></head>
<?php
sleep(1);
require_once("../db/connect.php");
$IDrol=$_POST["codRol"];
$sql=$dbh->prepare("select rol.IDrol, username from usuario,rol
					Where usuario.IDrol=rol.IDrol
					and rol.IDrol=? order by username");
$sql->bindParam(1,$IDrol);
$sql->execute();
?>
<img src="../images/rol de usuario.gif" height="20" width="30"><?php echo "Usuarios del rol: ".$IDrol."<br>";?>
<?php
if($sql->rowCount()>0){
	?>
    <table class="table">
         <th>Usuario</th>
    <?php
	foreach($sql->fetchAll() as $row){
		?>
        <tr><td><?php echo $row[1];?></td></tr>
        <?php
		}
     $count=$dbh->prepare("SELECT count( * ) AS usuarios, rol.IDrol
                           FROM usuario, rol
                           WHERE usuario.IDrol =rol.IDrol
						   and rol.IDrol=?
                           GROUP BY IDrol
                           ORDER BY IDrol");
	 $count->bindParam(1,$IDrol);				   
	 $count->execute();
	 $fila=$count->fetch();
	?>
       <tr> 
       <th colspan="1"><b>Cantidad de usuarios:   <?php echo $fila[0];?></b></th>
       </tr>
       </table>
    <?php
	}
	else{
		echo "Este rol todavia no tiene usuarios asignados";
		}
?>
</html>