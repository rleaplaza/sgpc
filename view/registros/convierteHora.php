<?php 
function convierteHora($hra){
    $hra = explode(":", $hra);
    return ($hra[0] + ($hra[1]/60) + ($hra[2]/3600));

}

?>