<?php declare(strict_types=1);

namespace App\Services\User\Read;

class ReadUserRequest
{
    private string $user;

    public function __construct(array $user)
    {
        $this->user = $user['email'];
    }

    public function user(): string
    {
        return $this->user;
    }
}