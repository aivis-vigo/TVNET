<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private ?int $id;
    private int $userId;
    private string $title;
    private string $body;
    private string $picture_url;
    private string $created_at;

    public function __construct(
        int    $userId,
        string $title,
        string $body,
        string $picture_url,
        string $created_at = null,
        ?int    $id = null
    )
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->picture_url = $picture_url;
        $this->created_at = $created_at ?? Carbon::now()->toTimeString();
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function picture(): string
    {
        return $this->picture_url;
    }

    public function createdAt(): string
    {
        return $this->created_at;
    }

    public function setAuthorId(int $id): void
    {
        $this->id = $id;
    }
}