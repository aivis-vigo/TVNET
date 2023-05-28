<?php declare(strict_types=1);

namespace App\Services\Article\Delete;

class DeleteArticleRequest
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}