<?php

ob_start();
require_once __DIR__ . '/controllers/UserController.php';

$controller = new UsersControllers();

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}


switch (true) {
    case $path === '/register' && $method === 'POST':
        $controller->Registerhttp();
        break;

        // case preg_match('#^/delete/(\d+)$#', $path, $matches) && $method === 'DELETE':
        //     $id = (int)$matches[1];
        //     $controller->Delete_user($id);
        //     break;
        //
        // case preg_match('#^/update/(\d+)$#', $path, $matches) && $method === 'PUT':
        //     $id = (int)$matches[1];
        //     $controller->UpdateUser($id);
        //     break;
        //

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
}
