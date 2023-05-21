<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;

class RandomArticleRepository implements ArticleRepository
{
    public function all(): array
    {
        $articles = [];
        for ($i = 0; $i < 5; $i++) {
            $articles[] = $this->randomArticle();
        }
        return $articles;
        //return [];
    }

    public function selectById(string $id): ?Article
    {
        return $this->randomArticle();
    }

    private function randomArticle(): Article
    {
        return new Article(
            1,
            1,
            'Random article ' . rand(1, 587),
            '- TEXT HERE -'
        );
    }
}