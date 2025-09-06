<?php

require_once __DIR__ . '/enrute.php';
require_once SRC_PATH.  '/infrastructure/persistence/DatabaseConfig.php';

$Conn = new DatabaseConecction();
$db = $Conn->getConnection();

if ($db) {
    echo"coneccion correcta";
} else {
    echo"valimos riata";
}


echo" hola mundo soy la riata";
