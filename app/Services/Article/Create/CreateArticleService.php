<?php declare(strict_types=1);

namespace App\Services\Article\Create;

use App\Models\Article;
use App\Repositories\Article\ArticleRepository;


class CreateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(CreateArticleRequest $request): CreateArticleResponse
    {
        $article = new Article(
            1,
            $request->title(),
            $request->body(),
            "https://placehold.co/600x400/png"
        );

        $this->articleRepository->create($article);

        return new CreateArticleResponse($article);
    }
}