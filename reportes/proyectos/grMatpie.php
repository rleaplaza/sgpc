<?php session_start();?>
<?php 
#Este programa se encarga de desplegar el gráfico de diferencias en duración del proyecto
require_once ('../../jpgraph/src/jpgraph.php');//llamada al framework jpgraph
require_once ('../../jpgraph/src/jpgraph_pie.php');//framework para la creacion de graficos tipo pie
require_once ('../../jpgraph/src/jpgraph_pie3d.php');//framework para gráficos en 3d
 require_once("../../db/connect.php");//LLama a la conexión de base de datos
 require_once("../../view/hora.php");//archivo para la función de despliegue de fecha y hora
 #recuperación de las variables de actividad y material
 try{
	 if(isset($_SESSION["username"])){
$idactividad=$_GET["idactividad"];
$actividad=$_GET["actividad"];
$idmaterial=$_GET["material"];
#consulta la información requerida para el material
$consulta=$dbh->prepare("select descripcion,unidad from material where IDmaterial=?");
$consulta->bindParam(1,$idmaterial);
$consulta->execute();
$res=$consulta->fetch();
$material=$res[0];
$unidad=$res[1];
#consulta las cantidades solicitada y la utilizada para porcentajes
$sql=$dbh->prepare("select cant_solicitada, cantidad_utilizada from actividad_material 
                    where IDactividad=?
					and IDmaterial=?");
$sql->bindParam(1,$idactividad);
$sql->bindParam(2,$idmaterial);
$sql->execute();
$res=$sql->fetch();
$cant_solicitada=$res["cant_solicitada"];
$cant_utilizada=$res["cantidad_utilizada"];
$diferencia=$cant_solicitada-$cant_utilizada;
$datos=array($diferencia,$cant_utilizada);
$fecha=getFecha();
$graph = new PieGraph(700,500);//define las dimensiones para la imagen gráfico
$graph->SetShadow();//agrega la sombra al gráfico
$theme_class= new OrangeTheme;//define el tema de apariencia
$graph->SetTheme($theme_class);//llama al metodo para establecer el color del gráfico
$graph->title->Set("Uso del material ".$material." ".$cant_solicitada." ".$unidad);//despliegue del título
$graph->title->SetFont(FF_FONT1,FS_BOLD);//Fuente del título
$graph->subtitle->set("Actividad: ".$actividad.", Fecha: ".$fecha);//imprime la fecha y hora del sistema
 
$p1 = new PiePlot3D($datos);//dibuja el gráfico en base a los datos introducidos de avances

$p1->SetSize(0.5);//radio del gráfico, no debe ser mayor a 0.5
$p1->SetCenter(0.55);//Posición del centro del gráfico
$p1->SetLegends(array("Cantidad por usar: ".$diferencia." ".$unidad,"Cantidad usada: ".$cant_utilizada." ".$unidad));//define la leyenda para referenciar el progreso de avances
$graph->legend->SetPos(0.1,0.1,'left','botton');//Setea la posición de los labels correspondientes a la leyenda del gráfico
$graph->Add($p1);//prepara el gráfico
$graph->Stroke();//genera la imagen con el gráfico
	 }else{
		 header("location: ../../index.php");
		 }
 }catch(PDOExeption $e){
	 echo "Error inesperado".$e->getMessage();
	 }
?>