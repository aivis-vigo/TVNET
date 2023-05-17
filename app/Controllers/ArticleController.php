<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\TwigView;

class ArticleController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function index(): TwigView
    {
        return new TwigView('articles', [
            'articles' => $this->client->fetchArticles()
        ]);
    }

    public function show(string $id): TwigView
    {
        $selectedArticle = $this->client->fetchSelectedArticle($id);

        if (!$selectedArticle) {
            return new TwigView('notFound', []);
        }

        return new TwigView('selectedArticle', [
            'articles' => $this->client->fetchSelectedArticle($id),
            'comments' => $this->client->fetchComments($id)
        ]);
    }
}