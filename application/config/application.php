<?php
return array(
    'configFiles'=>array(
        'database'           =>      APPLICATION.'/config/database.php'
    ),
    'defaultClass'=>array(
    	'controller'         =>      SYS_CORE_PATH.'/controller.php',
    	'model'              =>      SYS_CORE_PATH.'/model.php',
        'route'              =>      SYS_LIB_PATH.'/route/route.php', 
        'db'                 =>      SYS_LIB_PATH.'/database/mysql.php', 
        'template'           =>      SYS_LIB_PATH.'/template/template.php'
    )
);


?>