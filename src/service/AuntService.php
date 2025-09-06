<?php

use Dotenv\Validator;

require __DIR__ . '/../enrute.php';
require_once SRC_PATH.  'domain/Users.php';
require_once SRC_PATH. 'infrastructure/persistence/DatabaseConfig.php';
require_once SRC_PATH. 'infrastructure/persistence/UserRepository.php';
require_once SRC_PATH. 'service/JwtService.php';


class AuntServices
{
    private UserRepositoryClass $userRepository;
    private JwtService $jwt;

    public function __construct(UserRepositoryClass $userRepo)
    {
        $secret = getenv('JWT_SECRET') ?: 'ahsgds';
        $ttl = (int)(getenv('JWT_TTL') ?: 3600);
        $this->jwt = new JwtService($secret, $ttl);
        $this->userRepository = $userRepo;

    }

    public function Login(string $email, string $password): ?array
    {
        $Validate = $this->userRepository->findByEmail($email);

        if (!$Validate || !password_verify($password, $Validate->Get_password())) {
            return null;
        }

        $token = $this->jwt->generateToken($Validate);

        return [
            'user'  => $Validate,
            'token' => $token,
        ];


    }

}
