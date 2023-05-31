<?php declare(strict_types=1);

namespace App\Services\User\Read;

class ReadUserResponse
{
    private string $email;
    private string  $password;

    public function __construct(\stdClass $user)
    {
        $this->email = $user->e_mail;
        $this->password = $user->password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}