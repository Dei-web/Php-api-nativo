<?php

class User
{
    private ?int $id;
    private ?string $name;
    private ?string $email;
    private ?string $password;
    private ?string $role; // Nuevo campo

    public function __construct(
        ?string $name = null,
        ?string $email = null,
        ?string $password = null,
        ?string $role = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    // Getters
    public function Get_id(): ?int
    {
        return $this->id;
    }
    public function Get_name(): ?string
    {
        return $this->name;
    }
    public function Get_email(): ?string
    {
        return $this->email;
    }
    public function Get_password(): ?string
    {
        return $this->password;
    }
    public function Get_role(): ?string
    {
        return $this->role;
    }

    // Setters
    public function Set_id(int $id): void
    {
        $this->id = $id;
    }
    public function Set_name(string $name): void
    {
        $this->name = $name;
    }
    public function Set_email(string $email): void
    {
        $this->email = $email;
    }
    public function Set_password(string $password): void
    {
        $this->password = $password;
    }
    public function Set_role(string $role): void
    {
        $this->role = $role;
    }
}
