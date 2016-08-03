<?php
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
<link href="../../css/estilos.css" rel="stylesheet" type="text/css">
<link href="../../css/example.css" rel="stylesheet" type="text/css">
<link href="../../css/css.css" media="screen" rel="stylesheet" type="text/css" />
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
<?php
if(isset($_SESSION["username"])){
	echo ("<label>Registro eliminado</label>");
	}else{
		header("location: ../../index.php");
		}
?>
</body>
</html>