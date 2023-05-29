<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;

interface ArticleRepository
{
    public function all(): array;
    public function selectById(string $id): ?Article;
    public function create(Article $article): void;
    public function update(int $id, string $title, string $body): Void;
    public function read(string $id): Article;
    public function delete(string $id): void;
}