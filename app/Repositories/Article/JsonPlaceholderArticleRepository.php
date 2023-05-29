<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Cache;
use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class JsonPlaceholderArticleRepository implements ArticleRepository
{
    private Client $client;
    private Connection $connection;
    private QueryBuilder $queryBuilder;
    private const API_URL = "https://jsonplaceholder.typicode.com";

    public function __construct()
    {
        $this->client = new Client();

        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['HOST'],
            'driver' => $_ENV['DRIVER']
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->queryBuilder = $this->connection->createQueryBuilder();
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

    public function create(Article $article): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->insert('articles')
            ->values(
                [
                    'user_id' => '?',
                    'title' => '?',
                    'body' => '?'
                ]
            )
            ->setParameter(0, $article->userId())
            ->setParameter(1, $article->title())
            ->setParameter(2, $article->body())
            ->executeQuery();

        $article->setId((int)$this->connection->lastInsertId());
    }

    public function read(string $id): Article
    {
        return $this->read($id);
    }

    public function update(
        int    $id,
        string $title,
        string $body
    ): void
    {

    }

    public function delete(string $id): void
    {

    }

    private function buildArticle(\stdClass $article): Article
    {
        return new Article(
            rand(1, 10),//$article->user_id,
            $article->title,
            $article->body,
            "https://placehold.co/345x255/png",
            $article->created_at,
            $article->id
        );
    }
}