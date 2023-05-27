<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use function DI\string;

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

    public function show(string $id): TwigView
    {
        try {
            $response = $this->showArticleService->execute(new ShowArticleRequest($id));

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
            //'status_message' => $this->indexArticleService->edit()
        ]);
    }

    public function update(): TwigView
    {
        $title = $_REQUEST['title'];
        $body = $_REQUEST['body'];
        var_dump($title);

        return new TwigView('update', [
            'status_message' => $this->indexArticleService->update($title, $body)
        ]);
    }
}