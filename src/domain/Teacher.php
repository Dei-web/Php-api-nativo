<?php

require_once __DIR__ . '/Users.php';

class Teachers extends User
{
    private string $programa;
    private string $especialidad;

    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $role = "teacher",
        ?int $id = null,
        string $programa = "",
        string $especialidad = ""
    ) {
        parent::__construct($name, $email, $password, $role, $id);
        $this->programa = $programa;
        $this->especialidad = $especialidad;
    }

    // Getters
    public function Get_programa(): string
    {
        return $this->programa;
    }

    public function Get_especialidad(): string
    {
        return $this->especialidad;
    }

    // Setters
    public function Set_programa(string $programa): void
    {
        $this->programa = $programa;
    }

    public function Set_especialidad(string $especialidad): void
    {
        $this->especialidad = $especialidad;
    }
}
