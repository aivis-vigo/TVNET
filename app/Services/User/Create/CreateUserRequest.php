<?php declare(strict_types=1);

namespace App\Services\User\Create;

class CreateUserRequest
{
    private string $name;
    private string $email;
    private string $password;
    private string $confirmationPassword;

    public function __construct(array $user)
    {
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->password = $user['password'];
        $this->confirmationPassword = $user['passwordConfirmation'];
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

    public function confirmationPassword(): string
    {
        return $this->confirmationPassword;
    }
}