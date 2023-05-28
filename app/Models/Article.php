<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private int $id;
    private int $userId;
    private string $title;
    private string $body;
    private string $created_at;

    public function __construct(
        int    $id,
        int    $userId,
        string $title,
        string $body,
        string $created_at = null
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->created_at = $created_at ?? Carbon::now()->toTimeString();
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

    public function createdAt(): string
    {
        return $this->created_at;
    }
}