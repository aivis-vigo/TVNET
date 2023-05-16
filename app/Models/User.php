<?php declare(strict_types=1);

namespace App\Models;

class User
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private string $city;
    private string $companyName;

    public function __construct(
        int    $id,
        string $name,
        string $username,
        string $email,
        string $city,
        string $companyName
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->city = $city;
        $this->companyName = $companyName;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function companyName(): string
    {
        return $this->companyName;
    }
}