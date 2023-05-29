<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Article\ArticleRepository;
use App\Repositories\Comment\CommentRepository;
use App\Repositories\User\UserRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    //private UserRepository $userRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        //UserRepository $userRepository,
        CommentRepository $commentRepository
    )
    {
        $this->articleRepository = $articleRepository;
        //$this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
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