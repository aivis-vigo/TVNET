<?php declare(strict_types=1);

namespace App\Services\Article\Create;

class CreateArticleRequest
{
    private string $title;
    private string $body;

    public function __construct(
        string $title,
        string  $body
    )
    {
        $this->title = $title;
        $this->body = $body;
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