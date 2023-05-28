<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Article\Create\CreateArticleRequest;
use App\Services\Article\Create\CreateArticleService;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Read\ReadArticleRequest;
use App\Services\Article\Read\ReadArticleResponse;
use App\Services\Article\Read\ReadArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private CreateArticleService $createArticleService;
    private ReadArticleService $readArticleService;

    public function __construct(
        IndexArticleService  $indexArticleService,
        ShowArticleService   $showArticleService,
        CreateArticleService $createArticleService,
        ReadArticleService $readArticleService
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->createArticleService = $createArticleService;
        $this->readArticleService = $readArticleService;
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
            $response = $this->showArticleService->execute(
                new ShowArticleRequest(
                    $vars['id']
                )
            );

            return new TwigView('showArticle', [
                'articles' => [$response->article()],
                'comments' => $response->comments()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }

    public function create(): TwigView
    {
        return new TwigView('articles/create', []);
    }

    public function store(): TwigView
    {
        $createArticleResponse = $this->createArticleService->execute(
            new CreateArticleRequest(
                $_POST['title'],
                $_POST['body']
            )
        );

        return new TwigView('articles/status', [
            'status_message' => $createArticleResponse->status(),
            'color' => 'green'
        ]);
    }

    public function edit(): TwigView
    {
        $id = (basename($_SERVER['REQUEST_URI']));

        $article = $this->readArticleService->execute(
            new ReadArticleRequest($id)
        );

        return new TwigView('articles/update', [
            'contents' => $article,
            'color' => 'green'
        ]);
    }

    public function update(array $vars): TwigView
    {
        return new TwigView('articles/status', [
            'status_message' => $this->indexArticleService->update($vars['id'], $_POST),
            'color' => 'green'
        ]);
    }

    public function delete(array $vars): TwigView
    {
        return new TwigView('articles/status', [
            'status_message' => $this->indexArticleService->delete($vars['id']),
            'color' => 'red'
        ]);
    }
}