<?php


class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password, ?int $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    //here Getters without Get_password its funny this

    public function Get_id(): ?int
    {
        return $this->id;

    }

    public function Get_name(): string
    {
        return $this->name;
    }

    public function Get_email(): string
    {
        return $this->email;
    }

    public function Get_password(): string
    {
        return $this->password;
    }

    // All Setters

    public function Set_id(int $id): ?int
    {
        return $this->id = $id;
    }

    public function Set_email(string $email): string
    {
        return $this->email = $email;
    }

    public function Set_name(string $name): string
    {
        return $this->name = $name;
    }

    public function Set_password(int $password): string
    {
        return $this->password = $password;
    }


}
