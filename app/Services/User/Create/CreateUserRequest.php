<?php declare(strict_types=1);

namespace App\Services\User\Create;

class CreateUserRequest
{
    private array $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    public function user(): array
    {
        return $this->user;
    }
}