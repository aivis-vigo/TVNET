<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\ArticleRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->articleRepository->selectById($request->id());

        if ($article == null) {
            throw new ResourceNotFoundException('Article not found!');
        }

        $comments = $this->articleRepository->fetchArticleComments($request->id());

        return new ShowArticleResponse($article, $comments);
    }
}