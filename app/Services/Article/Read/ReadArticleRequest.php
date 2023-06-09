<?php declare(strict_types=1);

namespace App\Services\Article\Read;

class ReadArticleRequest
{
    private string $id;

    public function __construct(string $article)
    {
        $this->id = $article;
    }

    public function id(): string
    {
        return $this->id;
    }
}