<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Article\RandomArticleRepository;

class IndexArticleServices
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
    }

    public function execute(): array
    {
        return $this->articleRepository->all();
    }
}