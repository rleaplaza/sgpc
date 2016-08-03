<?php
#Este programa se encarga de generar cadenas aleatorias de 35 caracteres para que sean usados como IDs de registros
function generaPassword() {
	$lenght=8;//longitud de la cadena
 $key = '';//valor vacío
 $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';//caracteres numéricos y alfabéticos para combinarlos aleatoriamente
 //$pattern.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
 $max = strlen($pattern)-1;//almacena el máximo de longitud
 for($i=0;$i < $lenght;$i++)//el arreglo recorre la longitud de la cadena
  $key .= $pattern//concatena la cadena vacía a la cadena larga
  {mt_rand(0,$max)
  };//genera randómicamente el identificador
 return $key;//devuelve el ID generado
}
 
?>