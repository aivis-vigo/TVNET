<?php declare(strict_types=1);

namespace App\Controllers;

use App\Core\TwigView;
use App\Exceptions\ResourceNotFoundException;
use App\Services\Article\IndexArticleServices;
use App\Services\Article\Show\ShowArticleRequest;
use App\Services\Article\Show\ShowArticleService;

class ArticleController
{
    public function index(): TwigView
    {
        $service = (new IndexArticleServices());
        $articles = $service->execute();

        return new TwigView('articles', ['articles' => $articles]);
    }

    public function show(string $id): TwigView
    {
        try {
            $service = (new ShowArticleService());
            $response = $service->execute(new ShowArticleRequest($id));

            return new TwigView('selectedArticle', [
                'articles' => [$response->article()],
                'comments' => $response->comments()
            ]);
        } catch (ResourceNotFoundException $exception) {
            return new TwigView('notFound', []);
        }
    }
}