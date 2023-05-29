<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class RandomArticleRepository implements ArticleRepository
{
    private Connection $connection;
    private QueryBuilder $queryBuilder;

    public function __construct()
    {
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
        $articles = [];
        for ($i = 0; $i < 10; $i++) {
            $articles[] = $this->randomArticle();
        }
        return $articles;
    }

    public function selectById(string $id): ?Article
    {
        return $this->randomArticle();
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

    private function randomArticle(): Article
    {
        return new Article(
            1,
            'Random article - ' . rand(1, 587),
            'Hello',
            "https://placehold.co/600x400/png",
            null,
            rand(1, 10)
        );
    }

    public function read(string $id): Article
    {

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
}