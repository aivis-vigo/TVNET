<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\ArticleRepository;

class IndexArticleServices
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(): array
    {
        return $this->articleRepository->all();
    }
}