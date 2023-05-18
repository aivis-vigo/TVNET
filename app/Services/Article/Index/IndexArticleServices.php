<?php declare(strict_types=1);

namespace App\Services\Article\Index;

use App\ApiClient;

class IndexArticleServices
{
    private ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient();
    }

    public function execute(): array
    {
        return $this->client->fetchArticles();
    }
}