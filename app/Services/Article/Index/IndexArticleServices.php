<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\CombinedArticleRepository;

class IndexArticleServices
{
    private ArticleRepository $combinedArticleRepository;

    public function __construct()
    {
        $this->combinedArticleRepository = new CombinedArticleRepository();
    }

    public function execute(): array
    {
        return $this->combinedArticleRepository->all();
    }
}