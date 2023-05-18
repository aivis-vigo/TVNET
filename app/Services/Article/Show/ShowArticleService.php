<?php declare(strict_types=1);

namespace App\Services\Article\Show;

use App\ApiClient;
use App\Exceptions\ResourceNotFoundException;

class ShowArticleService
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(ShowArticleRequest $request): ShowArticleResponse
    {
        $article = $this->client->fetchSelectedArticle($request->id());

        if ($article == null) {
            throw new ResourceNotFoundException('Article not found!');
        }

        $comments = $this->client->fetchComments($request->id());

        return new ShowArticleResponse($article, $comments);
    }
}