<?php
#función para generar el código en base a las iniciales del nombre de un usuario
function generaCodigo($nom,$paterno,$materno) {
	$nom1=$nom[0];
	$paterno1=$paterno[0];
	$materno1=$materno[0];
	$nomaux=strtoupper($nom1);
	$paternoaux=strtoupper($paterno1);
	$maternoaux=strtoupper($materno1);
	$num=rand(100,1000);
	$userid=$nomaux.$paternoaux.$maternoaux."2013".$num;
	return $userid;
}
?>