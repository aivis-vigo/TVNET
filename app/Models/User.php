<?php declare(strict_types=1);

namespace App\Models;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        string $name,
        string $email,
        string $password,
        ?int    $id = null
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}