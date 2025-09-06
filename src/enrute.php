
<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', realpath(__DIR__ . '/../') . '/');
}

if (!defined('VENDOR_PATH')) {
    define('VENDOR_PATH', BASE_PATH . 'vendor/');
}

if (!defined('SRC_PATH')) {
    define('SRC_PATH', BASE_PATH . 'src/');
}

if (!class_exists('Composer\\Autoload\\ClassLoader')) {
    require_once VENDOR_PATH . 'autoload.php';
}
