<?php declare(strict_types=1);

namespace App\Services\Article\Delete;

class DeleteArticleResponse
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function status(): string
    {
        return $this->message;
    }
}