<?php

use PhpOption\None;

require __DIR__ . '/../enrute.php';
require_once SRC_PATH.  'domain/Users.php';
require_once SRC_PATH. 'infrastructure/persistence/DatabaseConfig.php';
require_once SRC_PATH. 'infrastructure/persistence/UserRepository.php';


class Service
{
    private UserRepositoryClass $userRepository;

    public function __construct(UserRepositoryClass $userRepo)
    {

        $this->userRepository = $userRepo;

    }

    public function Register(User $us): void
    {
        if (!filter_var($us->Get_email(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email inválido");
        }
        $this->userRepository->RegisterUser($us);
    }

}
