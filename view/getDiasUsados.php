<?php
function getDias($fec1,$fec2){//función para recuperar la cantidad de días del proyecto
	$segundos=strtotime($fec2) - strtotime($fec1);//convierte a segundos para realizar la diferencia
$diferencia_dias=intval($segundos/60/60/24);//convierte a valor entero
$dias=abs($diferencia_dias);//valor absoluto para convertir el valor de días a positivo
return $dias;//devuelve la cantidad de días
	}
	?>