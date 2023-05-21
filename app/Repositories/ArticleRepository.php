<?php declare(strict_types=1);

namespace App\Repositories;

use App\Cache;
use App\Models\Article;
use App\Models\Comment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ArticleRepository
{
    private Client $client;
    private const API_URL = "https://jsonplaceholder.typicode.com";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function all(): array
    {
        try {
            $collected = [];

            if (!Cache::has('allArticles')) {
                $client = $this->client->get(self::API_URL . "/posts");
                $responseJson = $client->getBody()->getContents();
                Cache::save('allArticles', $responseJson);
            } else {
                $responseJson = Cache::get('allArticles');
            }

            $response = json_decode($responseJson);

            foreach ($response as $article) {
                $collected[] = $this->buildArticle($article);
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function selectById(string $id): ?Article
    {
        try {
            if (!Cache::has("article_$id")) {
                $client = $this->client->get(self::API_URL . "/posts/$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("article_$id", $responseJson);
            } else {
                $responseJson = Cache::get("article_$id");
            }

            $response = json_decode($responseJson);

            return $this->buildArticle($response);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function fetchArticleComments(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("article_comments_$id")) {
                $client = $this->client->get( self::API_URL . "/comments?postId=$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("article_comments_$id", $responseJson);
            } else {
                $responseJson = Cache::get("article_comments_$id");
            }

            $comments = json_decode($responseJson);

            foreach ($comments as $comment) {
                $collected[] = $this->buildComment($comment);
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    private function buildArticle(\stdClass $article): Article
    {
        return new Article(
            $article->id,
            $article->userId,
            $article->title,
            $article->body
        );
    }

    private function buildComment(\stdClass  $comment): Comment
    {
        return new Comment(
            $comment->postId,
            $comment->name,
            $comment->email,
            $comment->body
        );
    }
}