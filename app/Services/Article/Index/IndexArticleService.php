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

    public function create(array $article): string
    {
        return $this->pdoArticleRepository->create($article);
    }

    public function read(string $id): Article
    {
        return $this->pdoArticleRepository->read($id);
    }

    public function update(string $id, array $content): string
    {
        return $this->pdoArticleRepository->update($id, $content);
    }

    public function delete(string $id): string
    {
        return $this->pdoArticleRepository->delete($id);
    }
}