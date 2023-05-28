<?php declare(strict_types=1);

namespace App\Services\Article\Read;

use App\Models\Article;

class ReadArticleResponse
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;
    private string $time;

    public function __construct(Article $article)
    {
        $this->id = $article->id();
        $this->userId = $article->userId();
        $this->title = $article->title();
        $this->body = $article->body();
        $this->time = $article->createdAt();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function created_at(): string
    {
        return $this->time;
    }
}