<?php

require_once __DIR__ . '/../../../vendor/autoload.php'; // ruta según tu estructura

use Predis\Client;

class RedisConecction
{
    private static $instance = null;

    public static function getClient()
    {
        if (!self::$instance) {
            self::$instance = new Client([
                'scheme' => 'tcp',
                'host' => '127.0.0.1',
                'port' => 6379
            ]);
        }
        return self::$instance;
    }
}
