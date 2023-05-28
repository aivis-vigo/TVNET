<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Article\Create\CreateArticleRequest;
use App\Services\Article\Create\CreateArticleService;
use App\Services\Article\Delete\DeleteArticleService;
use App\Services\Article\Delete\DeleteArticleRequest;
use App\Services\Article\Index\IndexArticleService;
use App\Services\Article\Read\ReadArticleRequest;
use App\Services\Article\Read\ReadArticleService;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;
use App\Services\Article\Update\UpdateArticleRequest;
use App\Services\Article\Update\UpdateArticleService;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;
    private CreateArticleService $createArticleService;
    private ReadArticleService $readArticleService;
    private UpdateArticleService $updateArticleService;
    private DeleteArticleService $deleteArticleService;

    public function __construct(
        IndexArticleService  $indexArticleService,
        ShowArticleService   $showArticleService,
        CreateArticleService $createArticleService,
        ReadArticleService   $readArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
        $this->createArticleService = $createArticleService;
        $this->readArticleService = $readArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->deleteArticleService = $deleteArticleService;
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
        $message = $this->updateArticleService->execute(
            new UpdateArticleRequest(
                $vars['id'],
                $_POST['title'],
                $_POST['body']
            )
        );

        return new TwigView('articles/status', [
            'status_message' => $message->status(),
            'color' => 'green'
        ]);
    }

    public function delete(array $vars): TwigView
    {
        $message = $this->deleteArticleService->execute(
            new DeleteArticleRequest(
                $vars['id']
            )
        );

        return new TwigView('articles/status', [
            'status_message' => $message->status(),
            'color' => 'red'
        ]);
    }
}