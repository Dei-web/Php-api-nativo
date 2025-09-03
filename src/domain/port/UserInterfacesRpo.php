<?php

require_once __DIR__ . '/../../enrute.php';
require_once SRC_PATH.  'domain/Users.php';


interface InterfaceRepo
{
    public function RegisterUser(User $us): User;
    public function DeleteUser(int $id): void;
    public function UpdateUser(User $us): User;
    public function GetAllUsersStudens(): ?array;
    public function GetAllUsersTeacher(): ?array;
    public function RegisterStudent(User $us, string $programa, float $calificacion, $foto = null): void;
    public function RegisterTeacher(User $us, string $programa, string $especialidad): void;



}
