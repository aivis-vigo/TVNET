<?php declare(strict_types=1);

namespace App\Services\Article\Update;

use App\Models\Article;
use App\Repositories\Article\ArticleRepository;

class UpdateArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(UpdateArticleRequest $request): UpdateArticleResponse
    {
        $this->articleRepository->update((int) $request->id(), $request->title(), $request->body());

        return new UpdateArticleResponse($request->id());
    }
}