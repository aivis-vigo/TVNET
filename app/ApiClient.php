<?php declare(strict_types=1);

namespace App;

use App\Models\Article;
use App\Models\Comment;
use GuzzleHttp\Client;

class ApiClient
{
    private Client $client;
    private string $url = "https://jsonplaceholder.typicode.com";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchArticles(): array
    {
        $collected = [];

        $client = $this->client->get($this->url . "/posts");
        $response = json_decode($client->getBody()->getContents());

        foreach ($response as $article) {
            $collected[] = new Article(
                $article->id,
                $article->title,
                $article->body
            );
        }
        return $collected;
    }

    public function fetchSelected(string $id): array
    {
        $collected = [];
        $client = $this->client->get($this->url . "/posts/$id");
        $response = json_decode($client->getBody()->getContents());

        $collected[] = new Article(
            $response->id,
            $response->title,
            $response->body
        );
        return $collected;
    }

    public function fetchComments(string $id): array
    {
        $collected = [];
        $client = $this->client->get($this->url . "/comments?postId=$id");
        $responseJson = $client->getBody()->getContents();
        $comments = json_decode($responseJson);

        foreach ($comments as $comment) {
            $collected[] = new Comment(
                $comment->postId,
                $comment->name,
                $comment->email,
                $comment->body
            );
        }
        return $collected;
    }
}