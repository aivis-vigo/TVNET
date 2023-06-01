<?php declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

interface UserRepository
{
    public function all(): array;
    public function selectById(string $id): ?User;
    public function selectByEmail(string $email): ?User;
    public function fetchUserArticles(string $id): array;
    public function create(User $user): void;
    public function read(string $user): \stdClass;
}