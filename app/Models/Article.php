<?php declare(strict_types=1);

namespace App\Models;

class Article
{
    private int $id;
    private string $title;
    private string $body;

    public function __construct(
        int    $id,
        string $title,
        string $body
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
    }

    public function id(): int
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