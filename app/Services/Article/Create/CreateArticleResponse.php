<?php declare(strict_types=1);

namespace App\Services\Article\Create;

use App\Models\Article;

class CreateArticleResponse
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function article(): Article
    {
        return $this->article;
    }
}