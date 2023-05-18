<?php declare(strict_types=1);

namespace App\Services\User\Show;

use App\Models\User;

class ShowUserResponse
{
    private User $user;
    private array $posts;

    public function __construct(User $user, array $posts)
    {
        $this->user = $user;
        $this->posts = $posts;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function posts(): array
    {
        return $this->posts;
    }
}