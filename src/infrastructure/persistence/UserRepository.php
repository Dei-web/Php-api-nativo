<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  '/domain/Users.php';
require_once SRC_PATH.  '/domain/Student.php';
require_once SRC_PATH.  '/domain/Teacher.php';
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


            $Sql = "INSERT INTO users (name, email, pass )
                VALUES (:name, :email, :password )";
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

    public function DeleteUser(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception("Usuario no encontrado");
        }
    }

    public function UpdateUser(User $us): User
    {
        try {
            $sql = "UPDATE users 
                SET name = :name, 
                    email = :email, 
                    pass = :password
                WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $us->Get_id(),
                ':name' => $us->Get_name(),
                ':email' => $us->Get_email(),
                ':password' => password_hash($us->Get_password(), PASSWORD_BCRYPT)
            ]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Usuario no encontrado o sin cambios");
            }

            return $us;

        } catch (\PDOException $e) {
            throw new Exception("Error al actualizar usuario: " . $e->getMessage(), 0, $e);
        }
    }
    public function GetAllUsersStudens(): ?array
    {
        $stmt = $this->pdo->query("SELECT U.id, U.name , U.email ,S.programa FROM users AS U
        INNER JOIN studens AS S ON S.user_id = U.id");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function GetAllUsersTeacher(): ?array
    {
        $stmt = $this->pdo->query("SELECT U.id, U.name , U.email ,T.especialidad FROM users AS U
        INNER JOIN teachers AS T ON T.user_id = U.id");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): ?User
    {
        try {
            $sql = "SELECT id, name, email, pass, role 
                FROM users 
                WHERE email = :email 
                LIMIT 1";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return new User(
                $row['name'],
                $row['email'],
                $row['pass'],
                $row['role'],
                $row['id']
            );
        } catch (\PDOException $e) {
            throw new Exception("Error buscando usuario por email: " . $e->getMessage(), 0, $e);
        }
    }

    public function RegisterStudent(Students $student): void
    {
        try {
            $sql = "CALL CreateStudent(:name, :email, :password, :programa, :calificacion, :foto)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $student->Get_name(),
                ':email' => $student->Get_email(),
                ':password' => password_hash($student->Get_password(), PASSWORD_BCRYPT),
                ':programa' => $student->Get_programa(),
                ':calificacion' => $student->Get_calificacion(),
                ':foto' => $student->Get_foto()
            ]);
        } catch (\PDOException $e) {
            throw new Exception("Error registrando estudiante: " . $e->getMessage(), 0, $e);
        }
    }

    public function RegisterTeacher(Teachers $teacher): void
    {
        try {
            $sql = "CALL CreateTeacher(:name, :email, :password, :programa, :especialidad)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $teacher->Get_name(),
                ':email' => $teacher->Get_email(),
                ':password' => password_hash($teacher->Get_password(), PASSWORD_BCRYPT),
                ':programa' => $teacher->Get_programa(),
                ':especialidad' => $teacher->Get_especialidad()
            ]);
        } catch (\PDOException $e) {
            throw new Exception("Error registrando profesor: " . $e->getMessage(), 0, $e);
        }
    }

    public function updatePassword(string $email, string $hashedPassword): void
    {
        $sql = "UPDATE users SET pass = :password WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':password' => $hashedPassword,
            ':email'    => $email
        ]);
    }


}
