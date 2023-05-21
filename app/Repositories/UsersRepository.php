<?php declare(strict_types=1);

namespace App\Repositories;

use App\Cache;
use App\Models\Article;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class UsersRepository
{
    private Client $client;
    private const URL = "https://jsonplaceholder.typicode.com";

    public function __construct()
    {
        $this->client = new Client();
    }

    public function all(): array
    {

        try {
            $collected = [];

            if (!Cache::has("allUsers")) {
                $client = $this->client->get(self::URL . "/users");
                $responseJson = $client->getBody()->getContents();
                Cache::save("allUsers", $responseJson);
            } else {
                $responseJson = Cache::get("allUsers");
            }

            $users = json_decode($responseJson);

            foreach ($users as $user) {
                $collected[] = $this->buildUser($user);
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    public function selectById(string $id): ?User
    {
        try {
            if (!Cache::has("user_$id")) {
                $client = $this->client->get(self::URL . "/users/$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("user_$id", $responseJson);
            } else {
                $responseJson = Cache::get("user_$id");
            }

            $user = json_decode($responseJson);

            return $this->buildUser($user);
        } catch (GuzzleException $exception) {
            return null;
        }
    }

    public function fetchUserPosts(string $id): array
    {
        try {
            $collected = [];

            if (!Cache::has("user_posts_$id")) {
                $client = $this->client->get(self::URL . "/posts/?userId=$id");
                $responseJson = $client->getBody()->getContents();
                Cache::save("user_posts_$id", $responseJson);
            } else {
                $responseJson = Cache::get("user_posts_$id");
            }

            $posts = json_decode($responseJson);

            foreach ($posts as $post) {
                $collected[] = $this->buildArticle($post);
            }
            return $collected;
        } catch (GuzzleException $exception) {
            return [];
        }
    }

    private function buildUser(\stdClass $user): User
    {
        return new User(
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->address->city,
            $user->company->name
        );
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
}