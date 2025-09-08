<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  'domain/Users.php';
require_once SRC_PATH.  'infrastructure/persistence/UserRepository.php';
require_once SRC_PATH.  'service/UserService.php';
require_once SRC_PATH.  'service/AuntService.php';
require_once SRC_PATH . '/infrastructure/persistence/RedisConecction.php';
require_once SRC_PATH . '/service/ServiceMailSender.php';
require_once SRC_PATH . '/Utils/util.php';


class UsersControllers
{
    private UserRepositoryClass $repo;
    private Service $service;
    private AuntServices $serviceAunt;

    public function __construct()
    {
        $this->repo = new UserRepositoryClass();
        $repo = new UserRepositoryClass();
        $this->service = new Service($repo);
        $this->serviceAunt = new AuntServices($repo);

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

    public function LoginHTTP(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: [];
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->serviceAunt->Login($email, $password);

        if (!$result) {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
            return;
        }

        $user = $result['user'];
        echo json_encode([
            'token' => $result['token'],
            'user'  => [
                'id'    => $user->Get_id(),
                'name'  => $user->Get_name(),
                'email' => $user->Get_email(),
                'rol'   => $user->Get_role(),
            ],
        ]);


    }

    public function GetAllStudensHTTP(): void
    {
        try {
            $users = $this->service->SelectAllStudents();
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'data' => $users
            ]);
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

    public function GetAllTeacherHTTP(): void
    {
        try {
            $users = $this->service->SelectAllStudents();
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'data' => $users
            ]);
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }

    }

    public function DeleteUserHTTP(int $id): void
    {
        try {
            $this->service->DeleteUserSer($id);
            http_response_code(200);
            echo json_encode(['status' => 'User Delete',]);
        } catch (\Throwable $e) {
            http_response_code(400);
            echo json_encode(['status' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
        }
    }


    public function ResetPasswordHTTP(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: [];

        $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $code = $data['code'] ?? null;
        $newPassword = $data['password'] ?? null;

        if (!$email || !$code || !$newPassword) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos.']);
            return;
        }

        try {
            $redis = RedisConecction::getClient();
            $storedCode = $redis->get("reset:$email");

            if (!$storedCode || $storedCode !== $code) {
                http_response_code(400);
                echo json_encode(['error' => 'Código inválido o expirado.']);
                return;
            }

            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->service->updatePasswordByEmail($email, $hashed);

            $redis->del("reset:$email");

            echo json_encode(['message' => 'Contraseña actualizada correctamente.']);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error interno del servidor', 'details' => $e->getMessage()]);
        }
    }

    public function SendEamilHTTP(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?: [];
        $email = trim($data['email'] ?? '');
        // var_dump($email);
        if (!$email) {
            http_response_code(400);
            echo json_encode(['error' => 'Email inválido.']);
            return;
        }

        $user = $this->repo->findByEmail($email);
        if (!$user) {
            http_response_code(400);
            echo json_encode(['error' => 'Email inválido.']);
            return;

        }

        try {
            $code = CodeGenerator::numericCode();

            $redis = RedisConecction::getClient();
            $redis->setex("reset:$email", 900, $code);

            $sender = new ServiceMailSender();
            $success = $sender->sendRecoveryCode($email, $code);

            if ($success) {
                echo json_encode(['message' => 'Código enviado correctamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'No se pudo enviar el correo.']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error'   => 'Error interno del servidor',
                'details' => $e->getMessage()
            ]);
        }
    }



}
