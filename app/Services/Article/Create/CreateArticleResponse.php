<?php declare(strict_types=1);

namespace App\Services\Article\Create;

class CreateArticleResponse
{
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function status(): string
    {
        return $this->status;
    }
}