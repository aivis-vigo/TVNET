<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;

interface ArticleRepository
{
    public function all(): array;
    public function selectById(string $id): ?Article;
}