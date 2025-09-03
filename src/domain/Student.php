<?php

require_once __DIR__ . '/Users.php';

class Students extends User
{
    private string $programa;
    private float $calificacion;
    private ?string $foto;

    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $role = "student",
        ?int $id = null,
        string $programa = "",
        float $calificacion = 0.0,
        ?string $foto = null
    ) {
        parent::__construct($name, $email, $password, $role, $id);
        $this->programa = $programa;
        $this->calificacion = $calificacion;
        $this->foto = $foto;
    }

    // Getters
    public function Get_programa(): string
    {
        return $this->programa;
    }

    public function Get_calificacion(): float
    {
        return $this->calificacion;
    }

    public function Get_foto(): ?string
    {
        return $this->foto;
    }

    // Setters
    public function Set_programa(string $programa): void
    {
        $this->programa = $programa;
    }

    public function Set_calificacion(float $calificacion): void
    {
        $this->calificacion = $calificacion;
    }

    public function Set_foto(?string $foto): void
    {
        $this->foto = $foto;
    }
}
