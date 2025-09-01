<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  'domain/Users.php';
require_once SRC_PATH.  'infrastructure/persistence/UserRepository.php';
require_once SRC_PATH.  'service/UserService.php';

class UsersControllers
{
    private Service $service;

    public function __construct()
    {
        $repo = new UserRepositoryClass();
        $this->service = new Service($repo);
        header('Content-Type: application/json');
    }

    public function Registerhttp(): void
    {
        $payload = json_decode(file_get_contents('php://input'), true) ?: [];
        $user = new User(
            $payload['name'] ?? '',
            $payload['email'] ?? '',
            $payload['password'] ?? ''
        );
        try {
            $this->service->Register($user);
            http_response_code(201);
            echo json_encode(['message' => 'Usuario registrado con éxito']);
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

}
