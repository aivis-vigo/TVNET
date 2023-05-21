<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\JsonPlaceholderArticleRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\Comment\JsonPlaceholderCommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        $this->articleRepository = new JsonPlaceholderArticleRepository();
        $this->commentRepository = new JsonPlaceholderCommentRepository();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->articleRepository->selectById($request->id());

        if ($article == null) {
            throw new ResourceNotFoundException('Article not found!');
        }

        $comments = $this->commentRepository->all($request->id());

        return new ShowArticleResponse($article, $comments);
    }
}