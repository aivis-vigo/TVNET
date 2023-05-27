<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\Exceptions\ResourceNotFoundException;
use App\Repositories\Article\PdoArticleRepository;
use App\Repositories\Comment\CommentRepository;

class ShowArticleService
{
    //private ArticleRepository $articleRepository;
    private PdoArticleRepository $pdoArticleRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        //ArticleRepository $articleRepository,
        PdoArticleRepository $pdoArticleRepository,
        CommentRepository $commentRepository
    )
    {
        //$this->articleRepository = $articleRepository;
        $this->pdoArticleRepository= $pdoArticleRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->pdoArticleRepository->selectById($request->id());

        if ($article == null) {
            throw new ResourceNotFoundException('Article not found!');
        }

        $comments = $this->commentRepository->all($request->id());

        return new ShowArticleResponse($article, $comments);
    }
}