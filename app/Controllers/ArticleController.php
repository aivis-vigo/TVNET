<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\Redirect;
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
use Carbon\Carbon;

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
        $_SESSION['count'] = ($_SESSION['count'] ?? 0) + 1;

        setcookie(
            'userName',
            'Aivis',
            (int) round(time() + (0.5 * 60 * 60))
        );

        $articles = $this->indexArticleService->execute();

        if (empty($articles)) {
            return new TwigView('notFound', []);
        }

        return new TwigView('indexArticles', ['articles' => $articles]);
    }

    public function show(array $vars): TwigView
    {
        try {
            $articleId = $vars['id'] ?? null;
            $response = $this->showArticleService->execute(
                new ShowArticleRequest(
                    $articleId
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

    public function store()
    {
        $createArticleResponse = $this->createArticleService->execute(
            new CreateArticleRequest(
                $_POST['title'],
                $_POST['body']
            )
        );

        $article = $createArticleResponse->article();

        // Redirect
        header('Location: /articles/' . $article->id());
    }

    public function edit(): TwigView
    {
        $id = explode("/", $_SERVER['REQUEST_URI']);

        $article = $this->readArticleService->execute(
            new ReadArticleRequest($id[2])
        );

        return new TwigView('articles/update', [
            'contents' => $article
        ]);
    }

    public function update(array $vars): Redirect
    {
        $this->updateArticleService->execute(
            new UpdateArticleRequest(
                $vars['id'],
                $_POST['title'],
                $_POST['body']
            )
        );

        return new Redirect('/articles/' . $vars['id']);
    }

    public function delete(array $vars)
    {
        $this->deleteArticleService->execute(
            new DeleteArticleRequest(
                $vars['id']
            )
        );

        header('Location: /articles');
    }
}