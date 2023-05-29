<?php declare(strict_types=1);

namespace App\Services\Article\Update;

use App\Models\Article;

class UpdateArticleResponse
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