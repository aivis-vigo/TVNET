<?php declare(strict_types=1);

namespace App\Services\Article\Update;

class UpdateArticleRequest
{
    private string $id;
    private string $title;
    private string $body;

    public function __construct(string $id, string $title, string $body)
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function body(): string
    {
        return $this->body;
    }
}