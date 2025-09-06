<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  'domain/Users.php';
require_once SRC_PATH.  'domain/Student.php';



interface InterfaceRepo
{
    public function RegisterUser(User $us): User;
    public function DeleteUser(int $id): void;
    public function UpdateUser(User $us): User;
    public function GetAllUsersStudens(): ?array;
    public function GetAllUsersTeacher(): ?array;
    public function RegisterStudent(Students $student): void;
    public function RegisterTeacher(Teachers $teacher): void;
    public function findByEmail(string $email): ?User;

}
