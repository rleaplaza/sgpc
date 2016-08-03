<?php
    //servidor MySql  
    $C_SERVER='tu_servidor';  
    //base de datos  
    $C_BASE_DATOS='tu_base_de_datos';  
    //usuario y contraseña de la base de datos mysql  
    $C_USUARIO='tu_usuario';  
    $C_CONTRASENA='tu_contraseña';  
    //ruta archivo de salida   
    //(el nombre lo componemos con Y_m_d_H_i_s para que sea diferente en cada backup)  
    $C_RUTA_ARCHIVO = '/ruta_hasta/backups/backup_'.date("Y_m_d_H_i_s").'.sql';  
    //si vamos a comprimirlo  
    $C_COMPRIMIR_MYSQL='true';  
      
      
    //comando  
    $command = "mysqldump --opt -h ".$C_SERVER." ".$C_BASE_DATOS." -u ".$C_USUARIO." -p".$C_CONTRASENA.  
         " -r \"".$C_RUTA_ARCHIVO."\" 2>&1";   
       
    //ejecutamos  
    system($command);  
      
    //comprimimos  
    if ($C_COMPRIMIR_MYSQL == 'true') {  
     system('bzip2 "'.$C_RUTA_ARCHIVO.'"');  
    }  
    ?>