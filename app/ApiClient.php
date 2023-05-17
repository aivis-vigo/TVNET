<?php declare(strict_types=1);

namespace App;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
        try {
            $collected = [];

            if (!Cache::has('allArticles')) {
                $client = $this->client->get($this->url . "/posts");
                $responseJson = $client->getBody()->getContents();
                Cache::save('allArticles', $responseJson);
            } else {
               $responseJson = Cache::get('allArticles');
            }

            $response = json_decode($responseJson);

            foreach ($response as $article) {
                $collected[] = new Article(
                    $article->id,
                    $article->userId,
                    $article->title,
                    $article->body
                );
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchSelected(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("article_$id")) {
                $client = $this->client->get($this->url . "/posts/$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("article_$id", $responseJson);
            } else {
                $responseJson = Cache::get("article_$id");
            }

            $response = json_decode($responseJson);

            $collected[] = new Article(
                $response->id,
                $response->userId,
                $response->title,
                $response->body
            );
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchComments(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("article_comments_$id")) {
                $client = $this->client->get($this->url . "/comments?postId=$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("article_comments_$id", $responseJson);
            } else {
                $responseJson = Cache::get("article_comments_$id");
            }

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
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchAllUsers(): array
    {

        try {
            $collected = [];

            if (!Cache::has("allUsers")) {
                $client = $this->client->get($this->url . "/users");
                $responseJson = $client->getBody()->getContents();
                Cache::save("allUsers", $responseJson);
            } else {
                $responseJson = Cache::get("allUsers");
            }

            $users = json_decode($responseJson);

            foreach ($users as $user) {
                $collected[] = new User(
                    $user->id,
                    $user->name,
                    $user->username,
                    $user->email,
                    $user->address->city,
                    $user->company->name
                );
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchUser(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("user_$id")) {
                $client = $this->client->get($this->url . "/users/$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("user_$id", $responseJson);
            } else {
                $responseJson = Cache::get("user_$id");
            }

            $user = json_decode($responseJson);

            $collected[] = new User(
                $user->id,
                $user->name,
                $user->username,
                $user->email,
                $user->address->city,
                $user->company->name
            );
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function fetchUserPosts(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("user_posts_$id")) {
                $client = $this->client->get($this->url . "/posts/?userId=$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("user_posts_$id", $responseJson);
            } else {
                $responseJson = Cache::get("user_posts_$id");
            }

            $posts = json_decode($responseJson);

            foreach ($posts as $post) {
                $collected[] = new Article(
                    $post->id,
                    $post->userId,
                    $post->title,
                    $post->body
                );
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }
}