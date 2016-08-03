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
				  #button{
			font-wight:bold;
			cursor:pointer;
			padding:5px;
			margin: 0 10px 20 px 0;
			border: 1px solid #ccc;
			background:#eee;
			border-radius:8px 8px 8px 8px;
			}
	     #button:hover{
			background:#ddd;
		 }
		      </style>
</head>

<body>
<?php
if(isset($_SESSION["username"])){
	echo ("<label>Actualizacion realizada</label>");
	?>
      <input type="submit" value="Volver a la página anterior" onClick='history.back();' id="button">
	<?php
	}else{
		header("location: ../../index.php");
		}
?>
</body>
</html>