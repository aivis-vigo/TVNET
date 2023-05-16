<?php declare(strict_types=1);

namespace App\Models;

class Comment
{
    private int $postId;
    private string $name;
    private string $email;
    private string $body;

    public function __construct(
        int    $postId,
        string $name,
        string $email,
        string $body
    )
    {
        $this->postId = $postId;
        $this->name = $name;
        $this->email = $email;
        $this->body = $body;
    }

    public function postId(): int
    {
        return $this->postId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function body(): string
    {
        return $this->body;
    }
}