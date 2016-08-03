<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../css/example.css" rel="stylesheet" type="text/css">
<link href="../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.accordion.min.css" rel="stylesheet" type="text/css">
<script src="../jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="../jQueryAssets/jquery-ui-1.9.2.accordion.custom.min.js" type="text/javascript"></script>
  <style>
  label{ font:Verdana, Geneva, sans-serif;
		 color:#00C;
	    }
legend{font:Verdana, Geneva, sans-serif;
	   color:#009;
	   size:auto;
 }
 </style>
</head>

<body>
<div id="Accordion1">
  <h3><a href="#"><label>NOSOTROS</label></a></h3>
  <div>
    <p><label>Diseñamos, gestionamos y construimos obras civiles de manera profesional con transparencia, puntualidad, formalidad y compromiso</label></p>
  </div>
  <h3><a href="#"><label>MISION</label></a></h3>
  <div>
    <p><label>Ser una empresa constructora dedicada a diseñar, gestionar y construir proyectos de obras civiles de forma profesional para el área profesional e industrial</label></p>
  </div>
  <h3><a href="#"><label>VISION</label></a></h3>
  <div>
    <p><label>Ser una empresa competente y flexible reconocida por brindar soluciones integrales de rubro de la construcción en nuestro país</label></p>
  </div>
  <h3><a href="#"><label>CONTACTOS</label></a></h3>
  <div>
  <p><label>Daniel Escobari<br>
   Calle Capitán Ravelo 2445<br>
   Tel. 591-2-2441845 OFC<br>
   Cel: 591 71025088</label></p>
  </div>
</div>
<script type="text/javascript">
$(function() {
	$( "#Accordion1" ).accordion(); 
});
</script>
</body>
</html>