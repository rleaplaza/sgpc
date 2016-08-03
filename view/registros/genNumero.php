<?php
#Función para generara cadenas de números aleatorios
function generaNumero() {
	$lenght=8;//longitud de la cadena
 $key = '';//valor vacío
 $pattern = '1234567890';//números del 0 al 9 para ser usados randómicamente
 //$pattern.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 $max = strlen($pattern)-1;//recupera el máximo de caracteres
 for($i=0;$i < $lenght;$i++)
  $key .= $pattern//concatena a la cadena de números
  {mt_rand(0,$max)};//genera el identificador randómicamente
 return $key;//devuelve el identificador generado
}
 
?>