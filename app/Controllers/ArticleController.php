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

    public function allArticles(): TwigView
    {
        return new TwigView('articles', [
            'articles' => $this->client->fetchArticles()
        ]);
    }

    public function selectedArticle(string $id): TwigView
    {
        return new TwigView('selectedArticle', [
            'articles' => $this->client->fetchSelected($id),
            'comments' => $this->client->fetchComments($id)
        ]);
    }
}