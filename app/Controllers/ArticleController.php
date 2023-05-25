<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService  $showArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        ShowArticleService $showArticleService
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
    }

    public function index(): TwigView
    {
        $articles = $this->indexArticleService->execute();

        if (empty($articles)) {
            return new TwigView('notFound', []);
        }

        return new TwigView('articles', ['articles' => $articles]);
    }

    public function show(string $id): TwigView
    {
        try {
            $response = $this->showArticleService->execute(new ShowArticleRequest($id));

            return new TwigView('selectedArticle', [
                'articles' => [$response->article()],
                'comments' => $response->comments()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }

    public function create(): TwigView
    {
        return new TwigView('create', []);
    }
}