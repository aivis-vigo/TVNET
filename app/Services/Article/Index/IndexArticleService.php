<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\Models\Article;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\PdoArticleRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;
    private PdoArticleRepository $pdoArticleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->pdoArticleRepository = new PdoArticleRepository();
    }

    public function execute(): array
    {
        return $this->articleRepository->all();
    }

    public function createNew(): string
    {
        return $this->pdoArticleRepository->create();
    }

    public function edit(): string
    {
        return $this->pdoArticleRepository->update();
    }

    public function getArticle(string $id): Article
    {
        return $this->pdoArticleRepository->read($id);
    }
}