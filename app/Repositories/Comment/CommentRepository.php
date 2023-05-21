<?php declare(strict_types=1);

namespace App\Repositories\Comment;

interface CommentRepository
{
    public function all(string $id): array;
}