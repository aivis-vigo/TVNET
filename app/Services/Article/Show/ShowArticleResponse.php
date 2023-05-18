<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Models\Article;

class ShowArticleResponse
{
    private Article $article;
    private array $comments;

    public function __construct(Article $article, array $comments)
    {
        $this->article = $article;
        $this->comments = $comments;
    }

    public function article(): Article
    {
        return $this->article;
    }

    public function comments(): array
    {
        return $this->comments;
    }
}