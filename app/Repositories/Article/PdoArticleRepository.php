<?php declare(strict_types=1);

namespace App\Repositories\Article;

use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

class PdoArticleRepository implements ArticleRepository
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
        $allUsers = [];

        $queryBuilder = $this->queryBuilder;

        $results = $queryBuilder
            ->select("*")
            ->from('articles')
            ->fetchAllAssociative();

        foreach ($results as $article) {
            $allUsers[] = $this->buildArticle((object)$article);
        }

        return $allUsers;
    }

    public function selectById(string $id): Article
    {
        $queryBuilder = $this->queryBuilder;

        $article = $queryBuilder
            ->select('*')
            ->from('articles')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->fetchAssociative();

        return $this->buildArticle((object)$article);
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
        $queryBuilder = $this->queryBuilder;
        $post = $queryBuilder
            ->select("*")
            ->from('articles')
            ->where('id = ' . $id)
            ->fetchAssociative();

        $article = (object)$post;

        return $this->buildArticle($article);
    }

    public function update(
        int    $id,
        string $title,
        string $body
    ): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->update('articles')
            ->set('title', '?')
            ->set('body', '?')
            ->setParameter(0, $title)
            ->setParameter(1, $body)
            ->where('id = ' . $id)
            ->executeQuery();
    }


    public function delete(string $id): void
    {
        $queryBuilder = $this->queryBuilder;
        $queryBuilder
            ->delete('articles')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
    }

    private function buildArticle(\stdClass $article): Article
    {
        return new Article(
            $article->user_id,
            $article->title,
            $article->body,
            "https://placehold.co/600x400/png",
            $article->created_at,
            $article->id
        );
    }
}