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

        return new TwigView('indexArticles', ['articles' => $articles]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $response = $this->showArticleService->execute(new ShowArticleRequest($vars['id']));

            return new TwigView('showArticle', [
                'articles' => [$response->article()],
                'comments' => $response->comments()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }

    public function createForm(): TwigView
    {
        $message = $this->indexArticleService->createNew();

        return new TwigView('create', ['status_message' => $message]);
    }

    public function edit(): TwigView
    {
        $id = (basename($_SERVER['REQUEST_URI']));
        return new TwigView('update', [
            'contents' => $this->indexArticleService->getArticle($id),
        ]);
    }

    public function update(array $vars): TwigView
    {
        return new TwigView('update', [
            'status_message' => $this->indexArticleService->update($vars['id'], $_REQUEST['title'], $_REQUEST['body'])
        ]);
    }
}