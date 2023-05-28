<?php declare(strict_types=1);

namespace App\Services\Article\Update;

class UpdateArticleResponse
{
    private string $status;

    public function __construct(string $message)
    {
        $this->status = $message;
    }

    public function status(): string
    {
        return $this->status;
    }
}