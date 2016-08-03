<?php session_start();//función de inicio de las sesión?>
<?php 
try{
	if(isset($_SESSION["username"])){
		if(isset($_GET["idactividad"])){
#Este programa se encarga de desplegar el gráfico de detalle de costo por actividad
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
require_once("../../db/connect.php");//LLama a la conexión de base de datos
require_once("../../view/hora.php");//archivo para la función de despliegue de hora
#captura de variables
$idactividad=$_GET["idactividad"];
$sql=$dbh->prepare("SELECT nombreActividad,t_actmaterial, t_acmanoobra,t_acmaquinaria,t_gastoadm,t_utilidad,t_impuesto,precioUnitarioBS
                    from actividad where IDactividad=?");
$sql->bindParam(1,$_GET["idactividad"]);
$sql->execute();// ejecuta el query
$row=$sql->fetch();//devuelve el resultado en un arreglo
$actividad=$row[0];
#asignación de las variables de la consulta
$totalmaterial=$row["t_actmaterial"];
$totalmanoobra=$row["t_acmanoobra"];
$totalmaquinaria=$row["t_acmaquinaria"];
$precio=$row["precioUnitarioBS"];
$data = array($totalmaterial,$totalmanoobra,$totalmaquinaria);//arreglo que será utilizado para desplegar el gráfico representando al detalle de precio en porcentajes
$fecha=getFecha();
$graph = new PieGraph(900,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new VividTheme;//define el tema de apariencia
 $graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Detalle del precio unitario: ". $actividad." ".$precio." Bs");//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Fecha ".$fecha); 
$p1 = new PiePlot3D($data);//dibuja el gráfico en base al arreglo definido

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.45);//Posición del centro del gráfico
$p1->SetLegends(array("Total materiales: ".$totalmaterial." Bs",
                      "Total Mano de obra: ". $totalmanoobra." Bs",
					  "Total equipo: ".$totalmaquinaria." Bs"));//define la leyenda para referenciar el detalle del precio unitario
$graph->legend->SetPos(0.1,0.1,'left','botton');
 
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
		}else{
			header("location: ../../index.php");
			}
	}else{
		header("location: ../../index.php");
		}
}catch(PDOException $e){
	echo "Error inesperado".$e->getMessage();
	}
?>