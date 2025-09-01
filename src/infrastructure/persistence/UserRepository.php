<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  '/domain/Users.php';
require_once SRC_PATH.  '/domain/port/UserInterfacesRpo.php';
require_once __DIR__ . '/DatabaseConfig.php';

class UserRepositoryClass implements InterfaceRepo
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new DatabaseConecction())->getConnection();
    }

    public function RegisterUser(User $us): User
    {
        try {

            $Sql = "CALL CreateUser(:name, :email, :password)";
            $stmt = $this->pdo->prepare($Sql);
            $stmt ->execute([
            ':name' => $us->Get_name(),
            ':email' => $us ->Get_email(),
            ':password' => password_hash($us->Get_password(), PASSWORD_BCRYPT)
            ]);
        } catch (\PDOException $e) {
            throw new Exception("Error Processing Request" . $e->getMessage(), 0, $e);
        }

        return $us;
    }
}
