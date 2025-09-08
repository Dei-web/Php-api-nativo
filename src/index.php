<?php

require_once __DIR__ . '/enrute.php';
require_once SRC_PATH.  '/infrastructure/persistence/DatabaseConfig.php';
require_once SRC_PATH.  '/infrastructure/persistence/RedisConecction.php';


$Conn = new DatabaseConecction();
$db = $Conn->getConnection();

$redis = RedisConecction::getClient();

if ($redis->ping()) {
    echo"redis ok";
} else {
    echo"error redes";
}




if ($db) {
    echo"coneccion correcta";
} else {
    echo"valimos riata";
}


echo" hola mundo soy la riata";
