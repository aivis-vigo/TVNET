<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\ArticleRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(): array
    {
        return $this->articleRepository->all();
    }
}