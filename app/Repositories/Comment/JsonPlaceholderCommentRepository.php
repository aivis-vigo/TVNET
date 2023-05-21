<?php declare(strict_types=1);

namespace App\Repositories\Comment;

use App\Cache;
use App\Models\Comment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class JsonPlaceholderCommentRepository implements CommentRepository
{
    private Client $client;
    private const API_URL = "https://jsonplaceholder.typicode.com";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function all(string $id): array
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