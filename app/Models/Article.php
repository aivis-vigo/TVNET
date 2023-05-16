<?php declare(strict_types=1);

namespace App\Models;

class Article
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;

    public function __construct(
        int    $id,
        int    $userId,
        string $title,
        string $body
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
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
}