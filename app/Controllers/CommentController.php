<?php declare(strict_types=1);

namespace App\Controllers;

use App\ApiClient;
use App\Core\TwigView;

class CommentController
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function allComments(string $id): TwigView
    {
        return new TwigView('selectedArticle', [
            'comments' => $this->client->fetchComments($id)
        ]);
    }
}